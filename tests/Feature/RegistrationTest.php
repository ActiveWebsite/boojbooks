<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_new_users_can_register()
    {
        $response = $this->post('/api/user/register', [
            'name' => 'Test User',
            'email' => 'test'.rand().'@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $data = json_decode($response->getContent(), true)['data'];
        $response->assertStatus(200);
        $this->assertIsNumeric($data['id']);
    }
}
