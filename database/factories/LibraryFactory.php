<?php

namespace Database\Factories;

use App\Models\Library;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibraryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Library::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order' => 1,
            'user_id' => \App\Models\User::factory(),
            'book_id' => \App\Models\Book::factory(),
        ];
    }
}
