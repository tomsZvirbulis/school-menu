<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Grade;
use App\Models\Days;
use App\Models\Ingredients;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 25) as $index) {
            DB::insert('insert into ingredient_category (name) values (?)', [Str::random(10)]);
        }

        foreach (range(1,100) as $index) {
            Ingredients::insert([
                'ingredient_category'=>random_int(1, 25),
                'name'=>Str::random(10),
            ]);
        }

        foreach (range(1,4) as $index) {
            Grade::insert([
                'minYear'=>$index,
                'maxYear'=>$index+2,
                'calories'=>$index*1000,
            ]);
        }

        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
        foreach (range(1,5) as $index) {
            Days::insert([
                'name'=>$days[$index-1],
                'day_index'=>$index,
            ]);
        }



    }

    public function ingred() {

        
    }
}
