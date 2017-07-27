<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Book;
use App\User;

class BookTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $book1 = [
        'title' => 'The Plague',
        'author' => 'Camus, Albert',
        'isbn13' => '',
        'publication_date' => ''
    ];
    
    protected $book2 = [
        'title' => 'The Fall',
        'author' => 'Camus, Albert',
        'isbn13' => '',
        'publication_date' => ''
    ];
    
    protected $book3 = [
        'title' => 'East of Eaden',
        'author' => 'John Steinbeck',
        'isbn13' => '',
        'publication_date' => ''
    ];
    
    public function setUp()
    {
        parent::setUp();
        
        $this->runDatabaseMigrations();
        
    	$user = factory(User::class)->create();
        $this->be($user);
        $this->user = $user;
    }
    
    public function testUserCreated()
    {
        $this->assertDatabaseHas('users', ['id' => 1]); # USER EXISTS
        $this->assertTrue(\Auth::user()->id === 1); # WE ARE LOGGED IN
    }
    
    
    public function testCreateBook()
    {
        $data = array_merge($this->book1, ['_token'=>csrf_token()]);
        $response1 = $this->post(route('books.store'), $data); # CREATE BOOK
        $response1->assertRedirect(route('books.index')); # REDIRECT TO BOOK INDEX
        
        $this->assertDatabaseHas('books', ['title' => 'The Plague']); # BOOK EXISTS
        
        $response2 = $this->post(route('books.store'), $data); # CREATE BOOK AGAIN
        $response2->assertStatus(500); # BOOK ALREADY EXISTS
    }
    
   
    public function testViewBook()
    {
        #$this->visit(route('books.show', '1'))->see($this->book1['title']);
        $this->browse(function ($browser) {
            $browser->visit(route('books.show', '1'))->assertSee($this->book1['title']);
        });
    }
    
    
    public function testChangeBookPosition()
    {
        #$user = \Auth::user();
        $book1 = Book::create($this->book1);
        $book2 = Book::create($this->book2);
        $book3 = Book::create($this->book3);
        
        $this->assertTrue($book1->position === '0');
        $this->assertTrue($book2->position === '1');
        $this->assertTrue($book3->position === '2');
        
        $book2->moveUp();
        
        $this->assertTrue($book1->position === '1');
        $this->assertTrue($book2->position === '0');
        $this->assertTrue($book3->position === '2');
        
        $book3->moveDown();
        
        $this->assertTrue($book1->position === '2');
        $this->assertTrue($book2->position === '0');
        $this->assertTrue($book3->position === '1');
    }
    
    public function testMoveBookDown()
    {
        
    }
    
    /*public function testUploadImage()
    {
        
    }
    
    public function testDeleteImage()
    {
        
    }
    
    public function testDeleteBook()
    {
        
    }*/
}
