<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $table = 'pizza';
    protected $fillable = ['name'];

    public function ingredients() {
        return $this->belongsToMany('App\Models\Ingredient', 'pizza_ingredient')->withPivot("quantity");
    }
}
