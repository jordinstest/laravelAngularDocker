<?php

use Illuminate\Database\Seeder;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredientNames = ["Bacon", "Cheese", "Olives", "Pineapple", "Mushroom", "Ham", "Salami", "Shrimp"];
        foreach($ingredientNames as $ingredientName) {
            DB::table('ingredient')->insert([
                'name' => $ingredientName
            ]);
        }
    }
}
