<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Recepie;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        return view('menu');
    }

    public function getLocal() {
        if (Auth::user()->caterer_id == null) {
            return ['error' => 'insufficient permision'];
        }

        if (Auth::user()->assigned_school == null) {
            return ['error' => 'You are not a worker'];
        }
        $recepies = Recepie::where('caterer_id', Auth::user()->caterer_id)->get();
        if (count($recepies) < 5) {
            return ['error' => 'Not enough recepies'];
        }
        $schools = School::where('id', Auth::user()->assigned_school)->get();
        $classes = Classes::where('school_id', Auth::user()->assigned_school)->get();
        if (count($classes) < 1) {
            return ['error' => 'No classes'];
        }
        return $classes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
