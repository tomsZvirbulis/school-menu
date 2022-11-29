<?php

namespace App\Actions\Fortify;

use App\Models\Address;
use Illuminate\Support\Facades\DB;
use App\Models\Caterer;
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
            'address' => ['required', 'string', 'max:255'],
            'address2' => ['max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'post_code' => ['required'],

            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // inserts address data
        Address::insert([
            'address' => $input['address'],   
            'address2' => $input['address2'],
            'city' => $input['city'],
            'country' => $input['country'],
            'district' => $input['district'],
            'postal_code' => $input['post_code'],
        ]);

        function getLastId($tableName) {
            return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
        }

        $usedId = getLastId('address');

        Caterer::insert([
            'name' => $input['company_name'],
            'address_id' => $usedId[0]->id,
        ]);
        $companyId = getLastId('caterer');


        return User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'caterer_id' => $companyId[0]->id,
            'master' => 1,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    
    }
}
