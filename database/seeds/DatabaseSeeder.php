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
		DB::statement('SET FOREIGN_KEY_CHECKS=0;'); # NEEDED TO ALLOW TRUNCATION OF TABLES WITH FOREIGN KEYS
        
        $this->call(UsersTableSeeder::class);
        
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
