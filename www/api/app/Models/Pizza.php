<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $table = 'pizza';
    protected $fillable = ['name'];

    public function ingredients() {
        $dbModel = $this->belongsToMany('App\Models\Ingredient', 'pizza_ingredient')->withPivot("quantity")
                        ->select("pizza_ingredient.ingredient_id", "pizza_ingredient.quantity");
        return $dbModel;
    }
}
