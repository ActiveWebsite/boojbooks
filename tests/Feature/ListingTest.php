<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Listing;
use App\Models\User;

class ListingTest extends TestCase
{

    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_can_create_listing() {

        $user = User::factory()->create();

        $this->actingAs($user);

        $listing = Listing::factory()->make();

        $response = $this->post(url('listing'), [
            'name' => $listing->name,
        ]);


        $response->assertStatus(302);
        $response->assertSessionHas("message", "Listing Created Successfully.");
        
        $this->assertDatabaseHas('listings', [
            'name' => $listing->name,
        ]);

    }

    public function test_can_modify_listing() {

        $user = User::factory()->create();
        $listing = Listing::factory()->create();

        $this->actingAs($user);

        $listing = Listing::first();

        $response = $this->put(url('listing', $listing->id), [
            'id' => $listing->id,
            'name' => "Updated Name",
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas("message", "Listing Updated Successfully.");
    }

    
    public function test_can_delete_listing() {

        $user = User::factory()->create();
        $listing = Listing::factory()->create();

        $this->actingAs($user);

        $listing = Listing::first();

        $response = $this->delete(url("listing/{$listing->id}/"), [
            'id' => $listing->id,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas("message", "List Deleted Successfully.");
    }
}
