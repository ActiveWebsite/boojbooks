<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|string[]
     */
    public function index()
    {
        if( request()->is('api/*')) {
            return ['data'=>"dashboard"];
        }else {
            return Inertia::render('Dashboard');
        }

    }
}
