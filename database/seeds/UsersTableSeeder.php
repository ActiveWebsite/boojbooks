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
    	DB::table('books')->truncate();
    	DB::table('users')->truncate();
        
        factory(App\User::class, 2)->create()->each(function ($u) {
            $n = 10;
            
            # RANDOMIZE BOOK ORDER
            $orders = range(0, $n);
            shuffle($orders);
            $books = factory(App\Book::class, $n)->make();
            
            foreach ($books as $key=>$value) {
                $books[$key]->position = $orders[$key];
            }
            
            # ENSURE TWO BOOKS HAVE THE SAME AUTHOR
            $books[8]->author = $books[3]->author;
            
            $u->books()->saveMany($books);
        });
        
        # XXX REDEFINE EMAIL ADDRESS OF FIRST USER TO SIMPLIFY LOGIN
        $user1 = App\User::find(1);
        $user1->email = 'x@y.com';
        $user1->save();
    }
}
