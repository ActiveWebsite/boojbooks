<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_CONNECTION') === 'mysql') { # NEEDED TO ALLOW TRUNCATION OF TABLES WITH FOREIGN KEYS IN MYSQL
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        
        $this->call(UsersTableSeeder::class);
        
        if (env('DB_CONNECTION') === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
    }
}
