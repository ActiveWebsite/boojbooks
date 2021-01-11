<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_remove_book()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->json('PUT', '/books', [
            'id' => 'mA8A4BYWB1IC',
            'image' => 'http://books.google.com/books/content?id=mA8A4BYWB1IC&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api',
            'pageCount' => 3264,
            'rating' => 4,
            'title' => 'A Game of Thrones 4-Book Bundle',
        ]);

        $response = $this->delete('/books/mA8A4BYWB1IC');

        $response->assertStatus(204);
    }
}
