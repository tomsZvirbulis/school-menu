<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'integer', 'max:255'],
            'company_type' => ['required', 'integer', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        if ($input['company_type'] == 1) {
            $type = 'school_id';
        } else {
            $type = 'caterer_id';
        };

        return User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            $type => $input['company_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
