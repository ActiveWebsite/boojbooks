<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->truncate();

        factory(App\User::class, 2)->create()->each(function ($u) {
            $n = 10;
            $orders = range(0, $n);
            shuffle($orders);
            $books = factory(App\Book::class, $n)->make();
            
            foreach ($books as $key=>$value) {
                $books[$key]->position = $orders[$key];
            }
            
            $u->books()->saveMany($books);
        });
    }
}
