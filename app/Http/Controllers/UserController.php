<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassHasGrade;
use App\Models\Grade;
use App\Models\IngredientCategory;
use App\Models\Ingredients;
use App\Models\Restrictions;
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
        if (!Auth::user()) {
            return view('home');
        } else if (Auth::user()->master == 1) {
            if (Auth::user()->caterer_id != null) {
                $res = School::where("caterer", Auth::user()->caterer_id)->get();
            } else {
                $hasManyClass = Classes::with('grade')->get()->toArray();
                $resHas = array();
                foreach ($hasManyClass as $key => $val) {
                    if ($val['school_id'] == Auth::user()->school_id && count($val['grade']) > 0) {
                        $resHas[] = $hasManyClass[$key];
                    }
                }
                $categories = IngredientCategory::all();
                $ingredient = array();
                foreach ($categories->toArray() as $category) {
                    $ingredient[] = Ingredients::where('ingredient_category', $category['id'])->get()->toArray();
                    $ingredient[count($ingredient)-1]['category'] = $category['name'];
                }
                $res = Grade::all();
            }
            
        } else {
            return view('home');
        }

        if (isset($resHas)) {
            return view('user', ['data' => $res, 'class_grade' => $resHas, 'ingredients' => $ingredient]);
        } else {
            return view('user', ['data' => $res]);
        }
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

            $grade = Grade::find(request('grade_id'));
 
            $grade->class()->attach($class[0]->id);

            return redirect('/user');
            
        }
    }

    public function addRestriction(Request $request) {
        if (Auth::user()->master == 0) {
            return response()->json(['error' => 'Insufficient permisions'], 500);
        }

        if (str_contains($request['ingredient'], 'C')) {
            $category_id = substr($request['ingredient'], 2);
            Restrictions::insert([
                'class_id' => $request['class_id'], 
                'category_id' => $category_id,
                'count' => $request['student_count'],
            ]);
        } else {
            Restrictions::insert([
                'class_id' => $request['class_id'], 
                'ingredients_id' => $request['ingredient'],
                'count' => $request['student_count'],
            ]);
        }
        return redirect('/user');

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
