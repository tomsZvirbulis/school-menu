<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recepie;
use App\Models\Instructions;
use App\Models\School;
use App\Models\RecepieHasIngredient;
use App\Models\IngredientCategory;

class RecepiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recepies');
    }

    public function getRecepies() {
        if (!Auth::user()) {
            return redirect()->route('login');
        } else if (isset(Auth::user()->school_id)) {
            return view('recepies');
        }
        if (Auth::user()->caterer_id !== null) {
            $res = Recepie::where('caterer_id', Auth::user()->caterer_id)->get();
            $ingredients = Ingredients::all();
        } else if (Auth::user()->school_id !== null) {
            $res = false;
        }
        

        return view('recepies', ['recepies'=>$res, 'ingredients' => $ingredients]);
    }

    public function createRecepies(Request $request) {
        if (Auth::user()->master !== 1) {
            return response()->json(['error' => 'Insufficient permisions'], 500);
        }
        $raw_data = $request->all();
        $decoded_data = json_decode($raw_data['data']);
        if (count($decoded_data)-1 <= 5) {
            return response()->json(['error' => 'Ingredient needed'], 500);
        }

        function getLastId($tableName) {
            return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
        }

        Instructions::insert([
            'instruction' => $decoded_data[6]->value,
        ]);

        $instr = getLastId('instructions');
        Recepie::insert([
            'name' => $decoded_data[1]->value,
            'prep_time' => $decoded_data[2]->value,
            'cook_time' => $decoded_data[3]->value,
            'calories' => $decoded_data[4]->value,
            'servings' => $decoded_data[5]->value,
            'instruction' => $instr[0]->id,
            'caterer_id' => Auth::user()->caterer_id,
        ]);
        $recepie_id = getLastId('recepie');

        for ($id = 7; $id < count($decoded_data); $id +=3) {
            RecepieHasIngredient::insert([
                'recepie' => $recepie_id[0]->id,
                'ingredient' => $decoded_data[$id]->value,
                'count' => $decoded_data[$id+1]->value,
                'measurements' => $decoded_data[$id+2]->value,
            ]);
        }
        return ['msg' => 'recepie added'];
    }


    public function delete($id) {
        if (Auth::user()->master == 1 && Auth::user()->caterer_id != null) {
            RecepieHasIngredient::where('recepie', $id)->delete();
            Recepie::where('id', $id)->delete();
        } else {
            return response()->json(['error' => 'Insufficient permisions'], 500);
        }
    }

    public function getRecepie($id) {

        if (Auth::user()->caterer_id) {
            $data = array();
            $recepies = Recepie::where('id', $id)->get();
            if ($recepies->toArray()[0]['caterer_id'] == Auth::user()->caterer_id) {
                foreach ($recepies->toArray() as $recepie) {
                    $data['recepies'] = $recepie;
                }
                $instructions = Instructions::where('id', $data['recepies']['instruction'])->get();
                $data['instruction'] = $instructions->toArray()[0]['instruction'];
                $ingr_has_recepie = RecepieHasIngredient::where('recepie', $data['recepies']['id'])->get();

                foreach ($ingr_has_recepie->toArray() as $key => $ingr_detail) {

                    $ingredients = Ingredients::where('id', $ingr_detail['ingredient'])->get();
                    $category = IngredientCategory::where('id', $ingredients->toArray()[0]['ingredient_category'])->get();

                    $ingredient = array();
                    $ingredient[] = $ingredients->toArray()[0]['name'];
                    $ingredient[] = $category->toArray()[0]['name'];
                    $ingredient[] = $ingr_detail['count'];
                    $ingredient[] = $ingr_detail['measurements'];
                    
                    $data['ingredients'][$key] = $ingredient;
                }
            }
            return view('recepie', ['data' => $data]);
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
