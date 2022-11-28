<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recepie;
use App\Models\School;

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

        if (Auth::user()->caterer_id !== null) {
            $res = Recepie::where('caterer_id', Auth::user()->caterer_id)->get();
        } else if (Auth::user()->school_id !== null) {
            $cater_id = School::where('id', Auth::user()->school_id)->get();
            dd($cater_id[0]);
        }
        

        return view('recepies', ['recepies'=>$res]);
    }

    public function createRecepies(Request $request) {
        if (Auth::user()->master !== 1) {
            return ['error' => 'insufficent permision'];
        }
        $raw_data = $request->all();
        $decoded_data = json_decode($raw_data['data']);
        if (count($decoded_data)-1 <= 5) {
            return ['error' => 'ingredient needed'];
        }

        function getLastId($tableName) {
            return DB::select('select id from '.$tableName.' order by id DESC limit 1;');
        }

        DB::insert('insert into recepie (name, prep_time, cook_time, calories, servings, caterer_id) values ("'.$decoded_data[1]->value.'", '.$decoded_data[2]->value.', '.$decoded_data[3]->value.', '.$decoded_data[4]->value.','.$decoded_data[5]->value.', '.Auth::user()->caterer_id.');');
        $recepie_id = getLastId('recepie');
        for ($id = 6; $id < count($decoded_data); $id +=2) {
            DB::insert('insert into ingredients (recepie, name, count) values ('.$recepie_id[0]->id.',"'.$decoded_data[$id]->value.'", '.$decoded_data[$id+1]->value.')');
        }
        return ['msg' => 'recepie added'];
    }


    public function delete($id) {
        if (Auth::user()->master == 1 && Auth::user()->caterer_id != null) {
            DB::delete('delete from ingredients where recepie ='.$id.';');
            DB::delete('delete from recepie where id ='.$id.';');
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
