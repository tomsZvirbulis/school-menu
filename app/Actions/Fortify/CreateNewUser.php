<?php

namespace App\Actions\Fortify;

use App\Models\Address;
use App\Models\Caterer;
use App\Models\User;
use App\Models\School;
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
            'address' => ['required', 'string', 'max:255'],
            'address2' => ['string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],

            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();
        
        Address::create([
            'address' => $input['address'],
            'address2' => $input['address2'],
            'city' => $input['city'],
            'district' => $input['district'],
            'post_code' => $input['post_code']
        ]);

        if ($input['company_type'] == 1) {
            $type = 'school_id';
            $obj = School::where('id', $input['company_id'])->get();
        } else {
            $type = 'caterer_id';
            $obj = Caterer::where('id', $input['company_id'])->get();
        };

        if(isset($obj[0])) {
            return User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                $type => $input['company_id'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        } else {
            // return render($request, $exception);
        }
    
    }
}
