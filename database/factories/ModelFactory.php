<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10)
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Book::class, function (Faker\Generator $faker) {
    # GENERATE SMALL LIST OF AUTHORS
    $n = 9;
    $authors = [];
    for ($i=0;$i<=$n;++$i) {
        $authors[] = $faker->lastName . ', ' . $faker->firstName;
    }
    
    return [
        'position' => 0, # POSITIONS WILL BE RANDOMIZED IN THE SEEDER
        'title' => $faker->name,
        'author' => $authors[mt_rand(0, $n)],
        'publication_date' => $faker->dateTimeBetween('1900-01-01','yesterday'),
        'isbn13' => '978' . str_random(10)
    ];
});
