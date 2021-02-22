<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Support\Str;
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
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(7),
            'isbn13' => $this->faker->randomNumber(8),
            'image' => 'https://itbook.store/img/books/9781484211830.png',
            'price' => '$'.$this->faker->randomNumber(2),
            'url' => $this->faker->url,
        ];
    }
}
