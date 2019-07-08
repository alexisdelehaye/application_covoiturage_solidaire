<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
    public static function getStops() {
        $stops = DB::table('stops')
            ->select('*')
            ->orderBy('zip', 'ASC')
            ->get();

        return $stops;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'brand' => 'required',
            'model' => 'required',
            'numberplate' => 'required',
            'color' => 'required',
            'seats' => 'required',
        ]);

        // Create car
        $car = new Car();
        $car->brand = ucfirst(strtolower($request->input('brand')));
        $car->model = ucfirst(strtolower($request->input('model')));
        $car->numberplate = implode('-', explode(' ', strtoupper($request->input('numberplate'))));
        $car->color = strtolower($request->input('color'));
        $car->seats = $request->input('seats');
        $car->user_id = auth()->user()->id;
        $car->save();

        return redirect('/dashboard')->with('success', 'Véhicule ajouté !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);

        // Check for correct user
        if(auth()->user()->id != $car->user_id)
            return redirect('/dashboard')->with('error', 'Erreur : Accès non autorisé.');

        return view('cars.edit')->with('car', $car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'numberplate' => 'required',
            'seats' => 'required',
        ]);

        // Update car
        $car = Car::find($id);
        $car->brand = $request->input('brand');
        $car->model = $request->input('model');
        $car->color = $request->input('color');
        $car->numberplate = $request->input('numberplate');
        $car->seats = $request->input('seats');
        $car->user_id = auth()->user()->id;
        $car->save();


        return redirect('/dashboard')->with('success', 'Véhicule modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);

        // Check for correct user
        if (auth()->user()->id != $car->user_id)
            return redirect('/dashboard/cars')->with('error', 'Erreur : accès non autorisé !');

        $car->delete();

        return redirect('/dashboard/cars')->with('success', 'Véhicule supprimé !');
    }

}
