<?php

namespace App\Http\Controllers\Menu;

use \App\Http\Controllers\Recepies\RecepiesController;
use App\Models\Classes;
use App\Models\Days;
use App\Models\Menu;
use App\Models\Recepie;
use App\Models\School;
use App\Models\MenuHasDay;
use App\Models\Restrictions;
use App\Models\Ingredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends \App\Http\Controllers\Controller
{
    /**
     * RecepiesController
     */
    protected $recepiesController;

    /**
     * @param $recepiesController RecepiesController
     */
    public function __construct(
        RecepiesController $recepiesController
    ) {
        $this->recepiesController = $recepiesController;
        $this->recepies = array();
    }

    public function index() {
        if (!Auth::user()) {
            return redirect()->route('login');
        } elseif (!Auth::user()->school_id && !Auth::user()->assigned_school) {
            return view('menu');
        }
        return view('menu', ['menu' => $this->initMenu()]);
    }

    /** 
     * @return array|null
     */
    public function initMenu() {
        if (Auth::user()->school_id) {
            $id = Auth::user()->school_id;
        } elseif (Auth::user()->assigned_school) {
            $id = Auth::user()->assigned_school;
        }
        if ($id && $this->menuExists($id) == false) {
            $this->getLocal();
            return $this->getMenu(Auth::user()->assigned_school);
        } elseif ($id && $this->menuExists($id) == true) {
            if (Auth::user()->school_id) {
                return $this->getMenu(Auth::user()->school_id);    
            } else {
                return $this->getMenu(Auth::user()->assigned_school);
            }
        } else {
            return null;
        }
    }

    /**
     * Returns every ingredient restriction for a class
     * 
     * @param int
     * @return array
     */
    public function classRestrictions($classId) {
        return DB::select('select res.class_id, chg.grade_id, res.ingredients_id, res.category_id, res.count from restrictions res 
        inner join school sc on sc.id = '.Auth::user()->assigned_school.' and res.class_id = '.$classId.'
        inner join class_has_grade chg on chg.class_id = res.class_id;');
    }

    public function restrictionIngredient($restrictions) {
        $tempRestrictions = array();
        foreach ($restrictions as $restriction) {
            if ($restriction->ingredients_id) {
                $tempRestrictions[] = $restriction->ingredients_id;
            } else if ($restriction->category_id) {
                $resIngredients = Ingredients::where("ingredient_category", $restriction->category_id)->pluck('id');
                foreach ($resIngredients as $resIngredient) {
                    $tempRestrictions[] = $resIngredient;
                }
            }
        }
        return array_unique($tempRestrictions);
    }

    /** 
     * @return json
     */
    public function menuErrors() {
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
    }

    /** 
     * @return bool
     */
    public function menuExists($school_id) {
        if (count(Menu::where("school_id", $school_id)->get()) == 0) {
            return FALSE;
        };
        return TRUE;
    }

    /** 
     * @param array
     */
    public function createGradeMenu($restrictions, $classData) {
        $normRecepies = $this->recepiesController->getRecepieInCalorie(($classData->calories)-100, ($classData->calories)+100);

        if (count($normRecepies) > 0) {
            $this->recepies[]["data"] = $classData;
            $this->recepies[array_key_last($this->recepies)]["recepies"] = $this->randomList($normRecepies, 5, $classData);
            if (count($restrictions) > 0) {
                $resRecepies = $this->recepiesController->getRestrictInCal($restrictions, ($classData->calories)-100, ($classData->calories)+100);
                if (count($resRecepies) < 5) {
                    $calAdded = 200;
                    while(count($resRecepies) >= 5 || $calAdded = 1100) {
                        $resRecepies = $this->recepiesController->getRestrictInCal($restrictions, ($classData->calories)-100, ($classData->calories)+100);
                        $calAdded +=100;
                    }
                }
                $this->recepies[array_key_last($this->recepies)]["res_rec"] = $this->randomList($resRecepies, 5, $classData);
            }
        }
    }

    /**
     * @param array
     * @param int
     * @return array|null
     */
    public function randomList($list, $itemCount, $cl) {
        if (count($list) < $itemCount) {
            return null;
        }
        $result = array();
        for ($i = 0; $i < $itemCount; $i++) {
            $randNum = rand(0, count($list)-1);
            $result[] = $list[$randNum];
            unset($list[$randNum]);
            $list = array_values($list);
        }
        return $result;
    }

    /**
     * @param array
     */
    public function saveMenu($menu) {
        foreach ($menu as $item) {
            if (array_key_exists('recepies', $item)) {
                $menuId = Menu::insertGetId([
                    'school_id' => Auth::user()->assigned_school,
                    'grade_id' => $item['data']->id, 
                    'restricted' => 0
                ]);
                foreach ($item['recepies'] as $index => $recepie) {
                    MenuHasDay::insert([
                        'menu' => $menuId,
                        'day' => $index+1, 
                        'recepie' => $recepie['id']
                    ]);
                }
            }
            if (count($item['res_rec']) > 0) {
                $resMenuId = Menu::insertGetId([
                    'school_id' => Auth::user()->assigned_school,
                    'grade_id' => $item['data']->id, 
                    'restricted' => 1
                ]);
                foreach ($item['res_rec'] as $index => $recepie) {
                    MenuHasDay::insert([
                        'menu' => $resMenuId,
                        'day' => $index+1, 
                        'recepie' => $recepie['id']
                    ]);
                }
            }
        }
    }

    /** 
     * @return array
     */
    public function getMenu($school_id) {
        $completeMenu = array();
        $menus = Menu::where("school_id", $school_id)->orderBy('grade_id', 'asc')->get();

        foreach ($menus as $index => $menu) {
            $menu = $menu->getAttributes();
            if ($menu["restricted"] == 0) {
               $completeMenu[$index]["data"] = $this->recepiesController->objectToArray(DB::select('
                SELECT
                    class.student_count student_count,
                    class.name name,
                    class.school_id school_id,
                    grade.minYear minYear,
                    grade.maxYear maxYear,
                    grade.calories calories
                FROM 
                    class_has_grade chg
                inner join class on chg.class_id = class.id and chg.class_id = '.$menu["grade_id"].'
                inner join grade on chg.grade_id = grade.id;
                '))[0];
                
                $recepies = $this->recepiesController->objectToArray(DB::select('
                SELECT
                    recepie.*
                FROM
                    recepie
                INNER JOIN menu_has_day mhd on mhd.recepie = recepie.id and mhd.menu = '.$menu["id"].'
                ORDER BY day;'));

                foreach ($recepies as $recepie) {
                    $completeMenu[$index]["recepies"][] = $recepie;
                };
                
            } elseif ($menu["restricted"] == 1) {
                $recepies = $this->recepiesController->objectToArray(DB::select('
                SELECT
                    recepie.*
                FROM
                    recepie
                INNER JOIN menu_has_day mhd on mhd.recepie = recepie.id and mhd.menu = '.$menu["id"].'
                ORDER BY day;'));

                foreach ($recepies as $recepie) {
                    $completeMenu[$index-1]["res_rec"][] = $recepie;
                };
            }
        }
        return $completeMenu;
    }

    /**
     * @param array
     */
    public function updateMenu($menus) {
        foreach ($menus as $menu) {
            $dbMenus = Menu::where("grade_id", $menu["data"]->id)->get();
            if (count($dbMenus) == 0) {
                $this->saveMenu([$menu]);
                continue;
            } elseif (count($dbMenus) == 1 && count($menu) == 3) {
                foreach ($dbMenus as $dbMenu) {
                    if ($dbMenu->getAttributes()['restricted'] == 0) {
                        unset($menu['recepies']);
                        $this->saveMenu([$menu]);
                    } else if ($dbMenu->getAttributes()['restricted'] == 1) {
                        unset($menu['res_rec']);
                        $this->saveMenu([$menu]);
                    }
                    continue;
                }
            }
            foreach ($dbMenus as $dbMenu) {
                if ($dbMenu->getAttributes()['restricted'] == 1) {
                    $recepies = 'res_rec';
                } else {
                    $recepies = 'recepies';
                }
                foreach ($menu[$recepies] as $index => $recepie) {
                    MenuHasDay::where('menu', $dbMenu->getAttributes()['id'])
                                ->where('day', $index+1)
                                ->update(['recepie' => $recepie['id']]);
                }
            }
        }
    }

    public function getLocal() {
        $this->menuErrors();
        if (Auth::user()->school_id !== null) {
            // return dd($this->getMenu(Auth::user()->school_id));
            return ['recepies' => $this->getMenu(Auth::user()->school_id)];
        }

        $grade_ids = DB::select('select distinct(chg.grade_id) from school
        inner join class on class.school_id = '.Auth::user()->assigned_school.'
        inner join class_has_grade chg on chg.class_id = class.id;');
        foreach ($grade_ids as $grade) {
            $class_info[] = DB::select('select grade.id, grade.minYear, grade.maxYear, grade.calories, sum(class.student_count) as total_students from class_has_grade chg 
            inner join class on class.id = chg.class_id
            inner join grade on grade.id = chg.grade_id and grade.id = '.$grade->grade_id.';')[0];
        };

        foreach ($class_info as $class_value) {
            $this->createGradeMenu($this->restrictionIngredient($this->classRestrictions($class_value->id)), $class_value);
        };
        if (Auth::user()->school_id) {
            $id = Auth::user()->school_id;
        } elseif (Auth::user()->assigned_school) {
            $id = Auth::user()->assigned_school;
        }
        if ($this->menuExists($id) == false) {
            $this->saveMenu($this->recepies);
        } elseif ($this->menuExists($id) == true) {
            $this->updateMenu($this->recepies);
            return ['recepies' => $this->getMenu(Auth::user()->assigned_school)];
        };
    }
}
