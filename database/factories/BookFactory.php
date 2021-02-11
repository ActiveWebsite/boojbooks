<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'listing_id' => Listing::factory(),
            'list_order' => $this->faker->numberBetween(0,100),
            'title' => $this->faker->title,
            'description' => $this->faker->title,
            'author' => $this->faker->name,
            'published' => now(),
            'length' => $this->faker->numberBetween(100,256),
            'rating' => $this->faker->numberBetween(0,5)
        ];
    }
}
