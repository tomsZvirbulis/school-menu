<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function registerWorker() {
        
    }

    public function data() {
        // $data = ['first_name', 'last_name', 'email', 'password', 'confirm_password'];
        // return view('user', compact('data'));
        return view('user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->caterer_id !=null) {
            $company = 'caterer_id';
            $company_id = Auth::user()->caterer_id;
        } else {
            $company = 'school_id';
            $company_id = Auth::user()->school_id;
        };

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
