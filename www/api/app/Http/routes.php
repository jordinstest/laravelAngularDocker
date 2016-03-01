<?php
use App\Http\Middleware;

if (array_key_exists('REQUEST_METHOD', $_SERVER) && $_SERVER['REQUEST_METHOD']=='OPTIONS') {
    header('Access-Control-Allow-Origin : http://frontend.test.com');
    header('Access-Control-Allow-Credentials : true');
    header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers : X-Requested-With, content-type');
}


Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'cors'], function()
{
    Route::resource('pizza', 'pizza\PizzaController');
    Route::resource('ingredient', 'pizza\IngredientController');
});


