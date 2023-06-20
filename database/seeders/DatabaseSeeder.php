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

        $food_categories = [
            "Fruit" => [
                "apple",
                "mangoe",
                "pineapple",
                "strawberry",
                "grape",
                "oranges",
                "pear",
                "peach",
                "plums",
                "raspberry"
            ],
            "Vegetable" => [
                "asparagus",
                "beet",
                "cabbage",
                "carrot",
                "broccoli",
                "cauliflower",
                "corn",
                "onion",
                "pea",
                "bell pepper",
                "leek",
                "green bean",
                "potato",
                "cucumber"
            ],
            "Dairy" => [
                "milk",
                "milk powder",
                "cheese",
                "butter",
                "margarine",
                "yogurt",
                "cream",
                "ice cream",
                "pasta"
            ],
            "Nuts" => [
                "Brazil nuts",
                "almonds",
                "cashews",
                "macadamia nuts",
                "pistachios",
                "pine nuts",
                "walnuts",
                "peanuts"
            ],
            "Grain" => [
                "Rice",
                "Buckwheat"
            ]
        ];

        $food_index = 1;
        foreach ($food_categories as $category => $products) {
            DB::insert('insert into ingredient_category (name) values (?)', [$category]);
            foreach ($products as $product) {
                Ingredients::insert([
                    'ingredient_category'=>$food_index,
                    'name'=> $product
                ]);
            }
            $food_index += 1;
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
