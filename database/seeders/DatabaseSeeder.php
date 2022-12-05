<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            DB::insert('insert into ingredients (ingredient_category, name) values (?, ?)', [random_int(1, 25) ,Str::random(10)]);
        }

    }

    public function ingred() {

        
    }
}
