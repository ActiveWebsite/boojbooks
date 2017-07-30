<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class BookTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    protected $book1 = [
        'title' => 'The Plague',
        'author' => 'Camus, Albert',
        'isbn13' => '9780679720218',
        'publication_date' => ''
    ];
    
    protected $book2 = [
        'title' => '1984',
        'author' => 'Orwell, George',
        'isbn13' => '',
        'publication_date' => '1949-06-08'
    ];
    
    protected $book3 = [
        'title' => 'East of Eaden',
        'author' => 'Steinbeck, John',
        'isbn13' => '',
        'publication_date' => ''
    ];
    
    public function setUp()
    {
        parent::setUp();
        
        url()->forceRootUrl(config('app.url')); # FIX FOR RUNNING APP NOT IN ROOT DIRECTORY
        
        $this->runDatabaseMigrations();
        
    	$user = factory(User::class)->create();
        $this->user = $user;
        $this->be($user);
    }
    
    public function testUserCreated()
    {
        $this->assertTrue(\Auth::check()); # WE ARE LOGGED IN
    }
    
    
    public function testCreateBook() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)->visit(route('books.create'))
                ->type('title', $this->book1['title'])
                ->type('author', $this->book1['author'])
                ->press('Submit')
                ->assertSee('Successfully added new book!');
            
            $this->assertDatabaseHas('books', [
                'title' => $this->book1['title']
            ]);
            
            $browser->loginAs($user)->visit(route('books.create'))
                ->type('title', $this->book1['title'])
                ->type('author', $this->book1['author'])
                ->press('Submit')
                ->assertSee('The title has already been taken.');
        });
    }
    
    
    public function testEditBook() {
        $user = $this->user;
        $book = $user->books()->create($this->book1);
        
        $this->browse(function ($browser) use ($user, $book) {
            $browser->loginAs($user)->visit(route('books.edit', $book->id))
                ->type('title', 'The Fall')
                ->press('Submit')
                ->assertSee('Successfully modified The Fall!');
            
            $this->assertDatabaseHas('books', [
                'title' => 'The Fall',
                'author' => $this->book1['author']
            ]);
        });
    }
    
    
    public function testDeleteBook() {
        $user = $this->user;
        $book = $user->books()->create($this->book1);
            
        $this->assertDatabaseHas('books', [
            'title' => $this->book1['title'],
        ]);
        
        $this->browse(function ($browser) use ($user, $book) {
            $browser->loginAs($user)->visit(route('books.show', $book->id))
                ->press('Delete')
                ->acceptDialog()
                ->assertSee($this->book1['title'].' has been removed from your list.');
        });
    }
    
    
    public function testChangeBookPosition()
    {
        $user = \Auth::user();
        $book1 = $user->books()->create($this->book1);
        $book2 = $user->books()->create($this->book2);
        $book3 = $user->books()->create($this->book3);
        
        $this->assertTrue($book1->position === 0);
        $this->assertTrue($book2->position === 1);
        $this->assertTrue($book3->position === 2);
        
        $book2->moveUp();
        
        $this->assertTrue($book1->fresh()->position === 1);
        $this->assertTrue($book2->fresh()->position === 0);
        $this->assertTrue($book3->fresh()->position === 2);
        
        $book1->moveDown();
        
        $this->assertTrue($book1->fresh()->position === 2);
        $this->assertTrue($book2->fresh()->position === 0);
        $this->assertTrue($book3->fresh()->position === 1);
    }
}
