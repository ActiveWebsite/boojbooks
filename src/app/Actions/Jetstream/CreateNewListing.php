<?php

namespace App\Actions\Fortify;

use App\Models\Listing;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesNewListings;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewListings
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
        ])->validate();

        return Listing::create([
            'name' => $input['name'],
            'user_id' => auth()->user()->id
        ]);
    }
}
