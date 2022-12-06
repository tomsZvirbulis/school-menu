<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Recepie;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            return response()->json(['error' => 'Insufficient permisions!'], 500);
        }

        if (Auth::user()->assigned_school == null) {
            return response()->json(['error' => 'You are not a worker!'], 500);
        }
        $recepies = DB::select('select * from recepie where caterer_id ='.Auth::user()->caterer_id);
        if (count($recepies) < 5) {
            return response()->json(['error' => 'Not enought recepies!'], 500);
        }
        $schools = School::where('id', Auth::user()->assigned_school)->get();
        $classes = Classes::where('school_id', Auth::user()->assigned_school)->get();
        if (count($classes) < 1) {
            return response()->json(['error' => 'No school classes!'], 500);
        }

        $grade_ids = DB::select('select distinct(chg.grade_id) from school
        inner join class on class.school_id = '.Auth::user()->assigned_school.'
        inner join class_has_grade chg on chg.class_id = class.id;');

        $class_info = array();
        foreach ($grade_ids as $grade) {
            $class_info[] = DB::select('select grade.minYear, grade.maxYear, grade.calories, sum(class.student_count) as total_students from class_has_grade chg 
            inner join class on class.id = chg.class_id
            inner join grade on grade.id = chg.grade_id and grade.id = '.$grade->grade_id.';')[0];
        }
        $possible_recepies = array();
        $real_recepies = array();
        foreach ($class_info as $key => $class_val) {
            $possible_recepies[] = array('calories' => $class_val->calories);
            $real_recepies[] = array('calories' => $class_val->calories);
            foreach ($recepies as $recepie) {
                // var_dump($recepie);
                if ($recepie->calories < $class_val->calories) {
                    $possible_recepies[$key][] = $recepie;
                }
            } 
            while (count($real_recepies[$key])-1 < 5) {
                $rand_num = rand(0, abs(count($possible_recepies[$key])-2));
                $real_recepies[$key][] = $possible_recepies[$key][$rand_num];
            }
            var_dump($possible_recepies[$key]);
        }
        
 
        // return $classes;
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
