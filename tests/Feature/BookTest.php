<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Listing;
use App\Models\Book;
use App\Models\User;

class BookTest extends TestCase
{

    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_can_create_listing_book() {

        $user = User::factory()->create();
        $listing = Listing::factory()->create();
        $book = Book::factory()->make();

        $this->actingAs($user);

        $response = $this->post(url("listing/{$listing->id}/book/"), [
            "title" => $book->title,
            "description" => $book->description,
            "listing_id" => $listing->id,
            "list_order" => $book->list_order,
            "author" => $book->author,
            "published" => $book->published,
            "length" => $book->length,
            "rating" => $book->rating
        ]);


        $response->assertStatus(302);
        $response->assertSessionHas("message", "Book Created Successfully.");

        #$response->dumpSession();
        
        $this->assertDatabaseHas('books', [
            'title' => $book->title,
        ]);

    }

    
    public function test_can_modify_listing_book() {

        $user = User::factory()->create();
        $listing = Listing::factory()->create();
        $book = Book::factory()->create(["listing_id" => $listing->id]);

        $this->actingAs($user);


        $response = $this->put(url("listing/{$listing->id}/book/{$book->id}"), [
            'id' => $book->id,
            'description' => $book->description,
            'title' => "Updated Name",
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas("message", "Book Updated Successfully.");
    }

    
    public function test_can_delete_listing() {

        $user = User::factory()->create();
        $listing = Listing::factory()->create();
        $book = Book::factory()->create(["listing_id" => $listing->id]);

        $this->actingAs($user);

        $response = $this->delete(url("listing/{$listing->id}/book/{$book->id}"), [
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas("message", "Book Deleted Successfully.");
    }
    
}
