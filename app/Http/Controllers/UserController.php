<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $guard;

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CreateNewUser $creator
     * @return array|array[]
     */
    public function store(Request $request, CreateNewUser $creator)
    {
        try{
            $user = $creator->create($request->all());
        }catch (\Exception $e){
            return ['data' => ['error' => $e->getMessage()]];
        }
        return ['data' => $user];
    }
}
