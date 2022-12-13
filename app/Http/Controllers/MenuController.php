<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Recepie;
use App\Models\School;
use App\Models\Restrictions;
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

    public function getRestriction($possible, $restrictions) {
        // fetches all recepies with restrictions
        // select * from recepie rec 
        // inner join recepie_has_ingredient rhi on rhi.recepie = rec.id
        // inner join restrictions res on res.ingredients_id = rhi.ingredient and rec.caterer_id = 1;
        $restriction_menu = array();
        $grade_restrictions = array();
        $grade_id = DB::select('select id from grade where minYear = '.$possible[0]['class_data']->minYear.' and maxYear= '.$possible[0]['class_data']->maxYear.';');
        // return var_dump($restrictions);
        foreach ($restrictions as $restriction) {
            if ($restriction->grade_id == $grade_id[0]->id) {
                if ($restriction->ingredients_id == NULL) {
                    $grade_restrictions[] = 'C_'.$restriction->category_id;
                } else {
                    $grade_restrictions[] = $restriction->ingredients_id;
                }
                
            }
        }
        return var_dump($grade_restrictions);
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

        if ($class_info)

        $possible_recepies = array();
        $real_recepies = array();
        foreach ($class_info as $key => $class_val) {
            $temp_array = array();
            foreach ($recepies as $recepie) {
                if ($recepie->calories < $class_val->calories + 100 && $recepie->calories > $class_val->calories - 100) {
                    $temp_array[] = $recepie;
                }
            } 

            if (count($temp_array) < 5) {
                continue;
            }

            $possible_recepies[] = array('class_data' => $class_val);
            $real_recepies[] = array('class_data' => $class_val);
            $possible_recepies[$key][] = $temp_array;

            if (count($possible_recepies[$key][0]) <= 4) {
                return response()->json(['error' => 'Not enough class recepies!'], 500);
            }

            $restrictions = DB::select('select res.class_id, chg.grade_id, res.ingredients_id, res.category_id, res.count from restrictions res 
            inner join class on class.id = res.class_id
            inner join school sc on sc.id = '.Auth::user()->assigned_school.'
            inner join class_has_grade chg on chg.class_id = res.class_id;');

            if (count($restrictions) > 0) {
                return $this->getRestriction($possible_recepies, $restrictions, $recepies);
            }

            // unset($possible_recepies[$key]['class_data']);
            while (count($real_recepies[$key])-1 < 5) {
                if (count($possible_recepies[$key][0]) == 1 && count($real_recepies[$key])-1 == 4) {
                    $real_recepies[$key][] = $possible_recepies[$key][0][0];
                    break;
                }
                $rand_num = rand(0, abs(count($possible_recepies[$key])-1));
                $real_recepies[$key][] = $possible_recepies[$key][0][$rand_num];
                unset($possible_recepies[$key][0][$rand_num]);
                $possible_recepies[$key][0] = array_values($possible_recepies[$key][0]);
            }
        }
        return ["recepies" => $real_recepies];

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
