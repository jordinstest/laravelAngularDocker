<?php

namespace App\Http\Controllers\pizza;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Models\Ingredient;
use \Log;



class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ingredients = Ingredient::all();
        return response()->json($ingredients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $name = $request->input('name');

        $ingredient = new Ingredient;
        $ingredient->name = $name;
        $ingredient->save();
        return response()->json($ingredient);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ingredient = new Ingredient;
        $ingredient->id = $id;
        $storedIngredient = $ingredient->find($id);
        return response()->json($storedIngredient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $newName = $request->input('name');

        $ingredient = new Ingredient;
        $ingredient->id = $id;
        $storedIngredient = $ingredient->find($id);
        $storedIngredient->name = $newName;
        $storedIngredient->save();

        return response()->json($storedIngredient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ingredient = new Ingredient;
        $ingredient->id = $id;
        $storedIngredient = $ingredient->find($id);

        if (!is_null($storedIngredient)) {
            Log::debug('Going to delete ingredient with id: '.$storedIngredient->id);
            $storedIngredient->delete();
        } else {
            Log::error("DELETE_INGREDIENT_ERROR: Can't delete ingredient with id ".$ingredient->id . " , because it doesn't exist");
            return response()->json(['DELETE_INGREDIENT_ERROR' => 'Can not delete ingredient'], 404);
        }
    }
}
