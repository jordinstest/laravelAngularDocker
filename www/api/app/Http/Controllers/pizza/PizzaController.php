<?php

namespace App\Http\Controllers\pizza;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Models\Pizza;
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
            'name' => 'required|max:255',
        ]);
        $name = $request->input('name');

        $pizza = new Pizza;
        $pizza->name = $name;
        $pizza->save();
        return response()->json($pizza->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $pizza = new Pizza;
        $pizza->id = $id;
        $storedPizza = $pizza->find($id);
        return response()->json($storedPizza);
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

        $pizza = new Pizza;
        $pizza->id = $id;
        $storedPizza = $pizza->find($id);
        $storedPizza->name = $newName;
        $storedPizza->save();

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
            $storedPizza->delete();
        } else {
            Log::error("DELETE_PIZZA_ERROR: Can't delete pizza with id ".$pizza->id . " , because it doesn't exist");
            return response()->json(['DELETE_PIZZA_ERROR' => 'Can not delete pizza'], 404);
        }
    }
}
