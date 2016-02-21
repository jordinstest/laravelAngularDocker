<?php

Route::get('/', function () {
    return view('welcome');
});

Route::resource('pizza', 'pizza\PizzaController');

