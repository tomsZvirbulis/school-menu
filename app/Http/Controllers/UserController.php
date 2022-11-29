<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassHasGrade;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Http\Controllers\getLastId as ControllersGetLastId;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user');
    }

    public function data() {
        if (Auth::user()->master == 1) {
            if (Auth::user()->caterer_id != null) {
                $res = School::where("caterer", Auth::user()->caterer_id)->get();
            } else {
                $res = Grade::all();
            }
            
        } else {
            $res = array();
        }

        
        return view('user', ['data' => $res]);
    }

    public function addClass(Request $request) {
        $data = $request->all();
        if (Auth::user()->school_id !=null && Auth::user()->master == 1) {
            function getLastId($tableName) {
                return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
            }
            Classes::insert([
                'student_count' => $data['student_count'], 
                'school_id' => Auth::user()->school_id,
                'name' => $data['class_name'],
            ]);
            $class = GetLastId('class');
            dd(array(request('grade_id')));
            ClassHasGrade::insert([
                'class_id' => $class,
                'grade_id' => request('grade_id'),
            ]);
        }
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
