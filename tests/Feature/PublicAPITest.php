<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicAPITest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $baseURL = 'https://www.googleapis.com/books/v1/volumes';
        $searchQuery = "Table";
        $startIndex  = 0;
        $maxResults  = 2;
        $endpoint = $baseURL."?q={$searchQuery}&startIndex={$startIndex}&maxResults={$maxResults}";
        $response = json_decode(file_get_contents($endpoint), true);
        $this->assertIsNumeric($response['totalItems']);
    }
}
