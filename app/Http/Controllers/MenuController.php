<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Days;
use App\Models\Menu;
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

    public function getRecepies() {
        $menus = Menu::where('school_id', Auth::user()->assigned_school)->get();

        $menu_result = array();
        if (count($menus) < 1) {
            return null;
        }
        foreach ($menus as $menu) {
            if ($menu->restricted == 1) {
                continue;
            }

            $grade_id = DB::select('select chg.grade_id from class
            inner join class_has_grade chg on chg.class_id = '.$menu->class_id.';');

            $menu_result[]['class_info'] = DB::select('
            select grade.id, grade.minYear, grade.maxYear, grade.calories, sum(class.student_count) as total_students from class_has_grade chg 
            inner join class on class.id = chg.class_id
            inner join grade on grade.id = chg.grade_id and grade.id = '.$grade_id[0]->grade_id.';')[0];

            $recepies = Days::where('menu_id', $menu->id)->get();

            $temp_recepie = array();
            foreach ($recepies as $recepie) {
                $temp_recepie[]['id'] = $recepie->id;
                $rec = Recepie::where('id', $recepie->recepie)->get();
                    foreach ($rec as $re) {
                        $temp_recepie[count($temp_recepie)-1]['recepie_name'] = $re->name;
                    }
                $temp_recepie[count($temp_recepie)-1]['name'] = $recepie->name;
                $temp_recepie[count($temp_recepie)-1]['day_index'] = $recepie->day_index;
                $temp_recepie[count($temp_recepie)-1]['menu_id'] = $recepie->menu_id;
                $temp_recepie[count($temp_recepie)-1]['recepie'] = $recepie->recepie;
            }

            $menu_result[count($menu_result)-1][] = $temp_recepie;

            $restricted_menus = $this->getRestrictedRecepies($menu->class_id);
            
            foreach ($restricted_menus as $restricted_menu) {
                $recepies = Days::where('menu_id', $restricted_menu->id)->get();
                $temp_recepie = array();
                foreach ($recepies as $recepie) {
                    $temp_recepie[]['id'] = $recepie->id;
                    $rec = Recepie::where('id', $recepie->recepie)->get();
                    foreach ($rec as $re) {
                        $temp_recepie[count($temp_recepie)-1]['recepie_name'] = $re->name;
                    }
                    $temp_recepie[count($temp_recepie)-1]['name'] = $recepie->name;
                    $temp_recepie[count($temp_recepie)-1]['day_index'] = $recepie->day_index;
                    $temp_recepie[count($temp_recepie)-1]['menu_id'] = $recepie->menu_id;
                    $temp_recepie[count($temp_recepie)-1]['recepie'] = $recepie->recepie;
                }
                $menu_result[count($menu_result)-1][] = $temp_recepie;
            }
        }

        

        return $menu_result;
    }

    public function getRestrictedRecepies($class_id) {
        $restricted_recepies = Menu::where('restricted', 1)->where('class_id', $class_id)->get();

        return($restricted_recepies);
    }

    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        return view('menu', ['menu' => $this->getRecepies()]);
    }

    public function saveMenu($recepies) {
        $result = array();
        foreach ($recepies as $recepie) {
            $norm_res = Menu::where('school_id', Auth::user()->assigned_school)->where('class_id', $recepie['class_data']->id)->where('restricted', 0)->get();
            if (count($norm_res) < 1) {
                Menu::insert([
                    'school_id'=> Auth::user()->assigned_school,
                    'class_id' => $recepie['class_data']->id,
                    'restricted' => 0,
                    'last_updated' => date("Y-m-d H:i:s"),
                ]);
            }
            $norm_res = Menu::where('school_id', Auth::user()->assigned_school)->where('class_id', $recepie['class_data']->id)->where('restricted', 0)->get();
            $days = Days::where('menu_id', $norm_res[0]->id)->get();
            $day_name = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
            if (count($days) < 1) {
                for ($index = 0; $index < 5; ++$index) {
                    Days::insert([
                        'name' => $day_name[$index],
                        'day_index' => $index+1,
                        'menu_id' => $norm_res[0]->id,
                        'recepie' => $recepie["recepies"][$index]->id,
                    ]);
                }
            } else {
                for ($index = 0; $index < 5; ++$index) {
                    $day = Days::where('menu_id', $norm_res[0]->id)->where('day_index', $index+1)->get();
                    $day[0]->recepie = $recepie["recepies"][$index]->id;
                    $day[0]->save();
                }
            }
            $days = Days::where('menu_id', $norm_res[0]->id)->get();
            $result[] = $days;
            if (array_key_exists('res_rec', $recepie)) {
                $restric_res = Menu::where('school_id', Auth::user()->assigned_school)->where('class_id', $recepie['class_data']->id)->where('restricted', 1)->get();
                if (count($restric_res) < 1) {
                    Menu::insert([
                        'school_id'=> Auth::user()->assigned_school,
                        'class_id' => $recepie['class_data']->id,
                        'restricted' => 1,
                        'last_updated' => date("Y-m-d H:i:s"),
                    ]);
                }
                $restric_res = Menu::where('school_id', Auth::user()->assigned_school)->where('class_id', $recepie['class_data']->id)->where('restricted', 1)->get();
                $days = Days::where('menu_id', $restric_res[0]->id)->get();
                if (count($days) < 1) {
                    for ($index = 0; $index < 5; ++$index) {
                        Days::insert([
                            'name' => $day_name[$index],
                            'day_index' => $index+1,
                            'menu_id' => $restric_res[0]->id,
                            'recepie' => $recepie['res_rec'][$index]->id,
                        ]);
                    }
                } else {
                    for ($index = 0; $index < 5; ++$index) {
                        $day = Days::where('menu_id', $restric_res[0]->id)->where('day_index', $index+1)->get();
                        $day[0]->recepie = $recepie['res_rec'][$index]->id;
                        $day[0]->save();
                    }
                }
                $days = Days::where('menu_id', $restric_res[0]->id)->get();
                $result[] = $days;
            }
        }
        return $result;
    }

    public function getRestriction($possible, $restrictions) {

        $restriction_menu = array();
        $grade_restrictions = array();
        $grade_id = DB::select('select id from grade where minYear = '.$possible[0]['class_data']->minYear.' and maxYear= '.$possible[0]['class_data']->maxYear.';');
        $res_categories = array();
        foreach ($restrictions as $restriction) {
            if ($restriction->grade_id == $grade_id[0]->id) {
                if ($restriction->ingredients_id == NULL) {
                    if (array_search($restriction->category_id, $res_categories) == false) {
                        $res_categories[] = $restriction->category_id;
                    }
                } else {
                    if (array_search($restriction->ingredients_id, $grade_restrictions) == false) {
                        $grade_restrictions[] = $restriction->ingredients_id;
                    }
                }
                
            }
        }

        if (count($res_categories) >= 1) {
            $res_cat_string = '';
            foreach ($res_categories as $index => $res_categorie) {
                if (count($res_categories) == $index+1) {
                    $res_cat_string .= strval($res_categorie);
                } else {
                    $res_cat_string .= strval($res_categorie).',';
                }
            }
        } else {
            $res_cat_string = 'null';
        }


        if (count($grade_restrictions) >= 1) {
            $res_in_string = '';
            foreach ($grade_restrictions as $index => $grade_restriction) {
                if (count($grade_restrictions) == $index+1) {
                    $res_in_string .= strval($grade_restriction);
                } else {
                    $res_in_string .= strval($grade_restriction).',';
                }
            }
        } else {
            $res_in_string = 'null';
        }

        $rec_string = '';
        foreach ($possible[1][0] as $index => $posible) {
            if (count($possible[1][0]) == $index+1) {
                $rec_string .= strval($posible->id);
            } else {
                $rec_string .= strval($posible->id).',';
            }
        }
        $res = DB::select('select * from recepie re where not exists (
                select * from recepie_has_ingredient rhi
                    where
                    ((rhi.recepie = re.id and re.caterer_id = '.Auth::user()->caterer_id.')
                    and 
                    (rhi.ingredient in ('.$res_in_string.') 
                        or 
                        rhi.ingredient in 
                            (select ingre.id from ingredients ingre where ingredient_category in ('.$res_cat_string.'))
                    ))
                ) and re.id IN ('.$rec_string.');');

        return $res;
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
        $classes = Classes::where('school_id', Auth::user()->assigned_school)->get();
        if (count($classes) < 1) {
            return response()->json(['error' => 'No school classes!'], 500);
        }

        $grade_ids = DB::select('select distinct(chg.grade_id) from school
        inner join class on class.school_id = '.Auth::user()->assigned_school.'
        inner join class_has_grade chg on chg.class_id = class.id;');

        $class_info = array();
        foreach ($grade_ids as $grade) {
            $class_info[] = DB::select('select grade.id, grade.minYear, grade.maxYear, grade.calories, sum(class.student_count) as total_students from class_has_grade chg 
            inner join class on class.id = chg.class_id
            inner join grade on grade.id = chg.grade_id and grade.id = '.$grade->grade_id.';')[0];
        }

        $real_recepies = array();
        foreach ($class_info as $key => $class_val) {
            $possible_recepies = array();
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
            $real_recepies[$key] = array('class_data' => $class_val);
            $possible_recepies[][] = $temp_array;

            if (count($possible_recepies[1][0]) <= 4) {
                return response()->json(['error' => 'Not enough class recepies!'], 500);
            }
            $restrictions = DB::select('select res.class_id, chg.grade_id, res.ingredients_id, res.category_id, res.count from restrictions res 
            inner join school sc on sc.id = '.Auth::user()->assigned_school.' and res.class_id = '.$class_val->id.'
            inner join class_has_grade chg on chg.class_id = res.class_id;');

            if (count($restrictions) > 0) {
                $res = $this->getRestriction($possible_recepies, $restrictions, $recepies);
                $possible_recepies[]['res_rec'] = array($res);
            }
    
            $rec_array = array();
            while (count($rec_array) < 5) {
                if (count($possible_recepies[1][0]) == 1 && count($real_recepies[$key])-1 == 4) {
                    $real_recepies[$key][] = $possible_recepies[1][0][0];
                    break;
                }
                $rand_num = rand(0, abs(count($possible_recepies[1][0])-1));

                $rec_array[] = $possible_recepies[1][0][$rand_num];
                unset($possible_recepies[1][0][$rand_num]);
                $possible_recepies[1][0] = array_values($possible_recepies[1][0]);
            }
            $real_recepies[$key]["recepies"] = $rec_array;

            if (array_key_exists(2, $possible_recepies)) {
                if (count($possible_recepies[2]) > 0) {
                    $rand = random_int(0, count($possible_recepies[2]['res_rec'][0])-1);
                    $real_recepies[$key]['res_rec'][] = $possible_recepies[2]['res_rec'][0][$rand];
                    while (count($real_recepies[$key]['res_rec']) < 5) {
                        $rand = random_int(0, count($possible_recepies[2]['res_rec'][0])-1);
                        if (count($possible_recepies[2]['res_rec'][0]) > 0) {
                            $real_recepies[$key]['res_rec'][] = $possible_recepies[2]['res_rec'][0][$rand];
                        }
                    }
                    
                }
            }
        }

        $this->savemenu($real_recepies);
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
