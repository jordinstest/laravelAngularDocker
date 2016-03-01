<?php

namespace App\Http\Controllers\pizza;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Models\Pizza;
use \App\Models\Ingredient;
use \Log;



class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pizzas = Pizza::all();
        return response()->json($pizzas);
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
            'name' => 'required|min:1|max:255',
        ]);
        $name = $request->input('name');

        $pizza = new Pizza;
        $pizza->name = $name;
        $pizza->save();

        $ingredients = $request->input('ingredients');

        foreach($ingredients as $ingredient) {
            $pizza->ingredients()->attach($ingredient["ingredient_id"], array("quantity"=>$ingredient["quantity"]));
        }

        $this->removePivotInfo($pizza);

        return response()->json($pizza);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $pizza = Pizza::with('ingredients')->find($id);
        $this->removePivotInfo($pizza);

        return response()->json($pizza);
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
        $this->validate($request, [
            'name' => 'required|min:1|max:255',
        ]);

        $pizza = new Pizza;
        $pizza->id = $id;
        $storedPizza = $pizza->find($id);
        $storedPizza->name = $newName;
        $storedPizza->save();

        $ingredients = $request->input('ingredients');
        if(count($ingredients) <= 0) {
            $ingredients = array();
        }
        $preparedIngredientData = array();

        foreach($ingredients as $ingredient) {
            $key = $ingredient["ingredient_id"];
            $preparedIngredientItem = array($key => array( 'quantity' => $ingredient["quantity"]));
            $preparedIngredientData += $preparedIngredientItem;
        }

        $storedPizza->ingredients()->sync($preparedIngredientData);
        $this->removePivotInfo($storedPizza);
        return response()->json($storedPizza);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $pizza = new Pizza;
        $pizza->id = $id;
        $storedPizza = $pizza->find($id);

        if (!is_null($storedPizza)) {
            Log::debug('Going to delete pizza with id: '.$storedPizza->id);
            $storedPizza->ingredients()->detach();
            $storedPizza->delete();
        } else {
            Log::error("DELETE_PIZZA_ERROR: Can't delete pizza with id ".$pizza->id . " , because it doesn't exist");
            return response()->json(['DELETE_PIZZA_ERROR' => 'Can not delete pizza'], 404);
        }
    }

    protected function removePivotInfo($pizza) {
        foreach($pizza->ingredients as $ingredient) {
            unset($ingredient->pivot);
        }
    }
}
