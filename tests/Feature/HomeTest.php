<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    
    public function testWelcomeTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testHomeTest()
    {
        $response = $this->get('/books');

        $response->assertRedirect('/login');
    }
}
