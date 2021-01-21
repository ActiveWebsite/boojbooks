<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookListTest extends TestCase
{
    private $user;

    /**
     * @return array
     */
    public function testGetApiData() {
        $baseURL = 'https://www.googleapis.com/books/v1/volumes';
        $searchQuery = "Table1";
        $startIndex  = 0;
        $maxResults  = 10;
        $endpoint = $baseURL."?q={$searchQuery}&startIndex={$startIndex}&maxResults={$maxResults}";

        $response =  json_decode(file_get_contents($endpoint), true);
        $this->assertIsNumeric($response['totalItems']);
        return $response;
    }

    /**
     * test Add a book
     * @depends testGetApiData
     * @param array $searchResults
     * @return array
     */
    public function test_save_list(array $searchResults)
    {
        $user  = User::factory()->create();
        $apiData = $searchResults;
        $books  = array();
        for ($i=0;$i<count($apiData['items']); $i++) {
            $book = $apiData['items'][$i];
            $data = [
                'title' => $book['volumeInfo']['title'],
                'cover_image'=> $book['volumeInfo']['imageLinks']['thumbnail'],
                'cover_image_small' => $book['volumeInfo']['imageLinks']['smallThumbnail'],
                'publication_date' => $book['volumeInfo']['publishedDate'],
                'description' => $book['volumeInfo']['description'],
                'authors' => $book['volumeInfo']['authors'],
                'publisher'  => $book['volumeInfo']['publisher'],
                'genres' => $book['volumeInfo']['categories'],
                'unique_id' =>$book['id'],
            ];
            if(isset($book['volumeInfo']['averageRating'])) {
                $data['rating'] = $book['volumeInfo']['averageRating'];
            }
            $this->actingAs($user);
            $response = $this->post('/api/books', $data);
            $data = json_decode($response->getContent(), true)['data'];
            $response->assertStatus(200);
            $this->assertIsNumeric($data['books'][0]['id']);
        }
        $books = $data['books'];
        return  ['user'=>$user,'books'=>$books];
    }

    /**
     * @depends test_save_list
     * @param $data
     */
    public function testRearrangeBooks($data) {
        $user = $data['user'];

        $books = $data['books'];
        $list_id = null;
        foreach ($books as $book) {
            $sequence[] = $book['id'];
            if(!$list_id) {
                $list_id = $book['list_id'];
            }
        }
        $originalSequence = implode(',', $sequence);
        shuffle($sequence);
        $data['sequence'] = $sequence;

        $this->actingAs($user);
        $response = $this->post('/api/books/rearrange/'.$list_id, $data);
        $data = json_decode($response->getContent(), true)['data'];
        $response->assertStatus(200);
        foreach($data['books'] as $book) {
            $newSequence[] = $book['id'];
        }
        $updatedSequence = implode(',', $newSequence);
        $this->assertNotEquals($originalSequence, $updatedSequence);
    }

    /**
     * @depends test_save_list
     * @param $data
     */
    public function testSortBooks($data) {
        $user = $data['user'];
        $books = $data['books'];

        foreach ($books as $book) {
            $sequence[] = $book['id'];
        }

        $originalSequence = implode(',', $sequence);

        $this->actingAs($user);
        $response = $this->get('/api/books?order_by=books.id%20asc', $data);
        $data = json_decode($response->getContent(), true)['data'];

        $response->assertStatus(200);

        foreach($data['books'] as $book) {
            $newSequence[] = $book['id'];
        }
        $updatedSequence = implode(',', $newSequence);
        $this->assertNotEquals($originalSequence, $updatedSequence);
    }

    /**
     * @depends test_save_list
     * @param $data
     */
    public function testRemoveBook($data) {
        $user = $data['user'];
        $books = $data['books'];

        foreach ($books as $book) {
            $sequence[] = $book['id'];
        }
        $bookToDeleteId = $sequence[0];
        $data['id'] = $bookToDeleteId;

        $this->actingAs($user);
        $response = $this->delete('/api/books', $data);
        $data = json_decode($response->getContent(), true)['data'];
        $response->assertStatus(200);
        foreach($data['books'] as $book) {
            $this->assertNotEquals($bookToDeleteId, $book['id']);
        }
    }
}
