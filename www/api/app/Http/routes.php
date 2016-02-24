<?php
use App\Http\Middleware;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'cors'], function()
{
    Route::resource('pizza', 'pizza\PizzaController');
    Route::resource('ingredient', 'pizza\IngredientController');
});


