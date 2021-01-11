<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReorderBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_reorder_books()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->json('PUT', '/books', [
            'id' => 'mA8A4BYWB1IC',
            'image' => 'http://books.google.com/books/content?id=mA8A4BYWB1IC&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api',
            'pageCount' => 3264,
            'rating' => 4,
            'title' => 'A Game of Thrones 4-Book Bundle',
        ]);

        $response = $this->json('PUT', '/books', [
            'id' => 'f280CwAAQBAJ',
            'image' => 'http://books.google.com/books/content?id=f280CwAAQBAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api',
            'pageCount' => 4236,
            'rating' => 4.5,
            'title' => 'Harry Potter: The Complete Collection (1-7)',
        ]);

        $response = $this->json('POST', '/books', [
            [
                'book_id' => 'mA8A4BYWB1IC',
                'order' => 1,
            ],
            [
                'book_id' => 'f280CwAAQBAJ',
                'order' => 0,
            ],
        ]);

        $response->assertStatus(204);

        $response = $this->get('/books');

        $response->assertJson([
            [
                'book_id' => 'mA8A4BYWB1IC',
                'order' => 1,
            ],
            [
                'book_id' => 'f280CwAAQBAJ',
                'order' => 0,
            ]]);

        $response->assertStatus(200);
    }
}
