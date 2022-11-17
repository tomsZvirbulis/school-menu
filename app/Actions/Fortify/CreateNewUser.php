<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\DB;
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
            'address2' => ['max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'post_code' => ['required'],

            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:100'],
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

        // inserts address data
        DB::insert('insert into address (address, address2, city, country, district, postal_code) values (?, ?, ?, ?, ?, ?)', [$input['address'], $input['address2'], $input['city'], $input['country'], $input['district'], $input['post_code']]);

        function getLastId($tableName) {
            return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
        }

        $usedId = getLastId('address');

        if ($input['company_type'] == 1) {
            $type = 'school_id';
            DB::insert('insert into school (name, address_id) values (?, ?)', [$input['company_name'], $usedId[0]->id]);
            $companyId = getLastId('school');
        } else {
            $type = 'caterer_id';
            DB::insert('insert into caterer (name, address_id) values (?, ?)', [$input['company_name'], $usedId[0]->id]);
            $companyId = getLastId('caterer');
        };


        return User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            $type => $companyId[0]->id,
            'master' => 1,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    
    }
}
