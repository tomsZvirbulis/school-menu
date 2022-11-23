<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\School;

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


    public function data($caterer_id) {
        if (Auth::user()->master == 1 && Auth::user()->caterer_id == $caterer_id) {
            $res = School::where("caterer", $caterer_id)->get();
        } else {
            $res = array();
        }
        
        return view('user', ['schools' => $res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function createSchool() {
        if (Auth::user()->caterer_id !=null && Auth::user()->master == 1)  {
            $company = 'caterer_id';
            $company_id = Auth::user()->caterer_id;
        }

        function getLastId($tableName) {
            return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
        }
        DB::insert('insert into address (address, address2, city, country, district, postal_code) values (?, ?, ?, ?, ?, ?)', [request('address'), request('address2'), request('city'), request('country'), request('district'), request('post_code')]);
        $addressId = getLastId('address');
        $caterer = Auth::user()->caterer_id;
        

        if (request('password') === request('confirm_password')) {
            $hashed = Hash::make(request('password'));
            DB::insert('insert into school (name, address_id, caterer) values ("'.request('name').'",
                '.$addressId.', '.$caterer.')');
        };
    }

    public function createWorker()
    {
        if (Auth::user()->caterer_id !=null && Auth::user()->master == 1) {
            $company = 'caterer_id';
            $company_id = Auth::user()->caterer_id;
        }

        if (request('password') === request('confirm_password')) {
            $hashed = Hash::make(request('password'));
            DB::insert('insert into users (first_name, last_name, master, email, password, '.$company.') values ("'.request('first_name').'",
                "'.request('last_name').'", 0, "'.request('email').'", "'.$hashed.'", '.$company_id.')');
        };

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
