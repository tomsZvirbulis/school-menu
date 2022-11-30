<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\User;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function createSchool() {
        if (Auth::user()->caterer_id !=null && Auth::user()->master == 1)  {

            function getLastId($tableName) {
                return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
            }
            Address::insert([
                'address' => request('address'),   
                'address2' => request('address2'),
                'city' => request('city'), 
                'country' => request('country'), 
                'district' => request('district'), 
                'postal_code' => request('post_code'),
            ]);
            $addressId = getLastId('address');
            $caterer = Auth::user()->caterer_id;
            
            if (request('password') === request('confirm_password')) {
                $hashed = Hash::make(request('password'));
                School::insert([
                    'name' => request('school_name'),
                    'address_id' => $addressId[0]->id,
                    'caterer' => $caterer,
                ]);
                $school_id = getLastId('school');
                User::insert([
                    'first_name' => request('first_name'),
                    'last_name' => request('last_name'),
                    'master' => 1,
                    'email' => request('email'),
                    'password' => $hashed,
                    'school_id' => $school_id[0]->id,
                ]);
            };
            return redirect('/user');
        }
    }

    public function createWorker()
    {
        if (Auth::user()->caterer_id !=null && Auth::user()->master == 1) {
            $company_id = Auth::user()->caterer_id;
            if (request('password') === request('confirm_password')) {
                $hashed = Hash::make(request('password'));
                User::insert([
                    'first_name' => request('first_name'),
                    'last_name' => request('last_name'),
                    'master' => 0,
                    'email' => request('email'),
                    'password' => $hashed,
                    'caterer_id' => $company_id,
                    'assigned_school' => request('school_id'),
                ]);
                return redirect('/user');
            };
        }

        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
