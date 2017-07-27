<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('DB_CONNECTION') === 'sqlite') { # ENABLE FOREIGN KEYS IF USING SQLITE
            \DB::statement(\DB::raw('PRAGMA foreign_keys = ON;'));
        } else if (env('DB_CONNECTION') === 'mysql') { # FIX FOR MARIADB < 10.2
            \Schema::defaultStringLength(191);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
