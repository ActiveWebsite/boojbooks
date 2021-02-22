<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Library;

use App\Models\Book;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LibraryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_libraries()
    {
        $libraries = Library::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('libraries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.libraries.index')
            ->assertViewHas('libraries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_library()
    {
        $response = $this->get(route('libraries.create'));

        $response->assertOk()->assertViewIs('app.libraries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_library()
    {
        $data = Library::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('libraries.store'), $data);

        $this->assertDatabaseHas('libraries', $data);

        $library = Library::latest('id')->first();

        $response->assertRedirect(route('libraries.edit', $library));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_library()
    {
        $library = Library::factory()->create();

        $response = $this->get(route('libraries.show', $library));

        $response
            ->assertOk()
            ->assertViewIs('app.libraries.show')
            ->assertViewHas('library');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_library()
    {
        $library = Library::factory()->create();

        $response = $this->get(route('libraries.edit', $library));

        $response
            ->assertOk()
            ->assertViewIs('app.libraries.edit')
            ->assertViewHas('library');
    }

    /**
     * @test
     */
    public function it_updates_the_library()
    {
        $library = Library::factory()->create();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $data = [
            'order' => $this->faker->randomNumber(0),
            'user_id' => $user->id,
            'book_id' => $book->id,
        ];

        $response = $this->put(route('libraries.update', $library), $data);

        $data['id'] = $library->id;

        $this->assertDatabaseHas('libraries', $data);

        $response->assertRedirect(route('libraries.edit', $library));
    }

    /**
     * @test
     */
    public function it_deletes_the_library()
    {
        $library = Library::factory()->create();

        $response = $this->delete(route('libraries.destroy', $library));

        $response->assertRedirect(route('libraries.index'));

        $this->assertDeleted($library);
    }
}
