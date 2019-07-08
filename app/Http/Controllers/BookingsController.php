<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Route;

class BookingsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'user_id' => 'required',
            'route_id' => 'required',
            'seats' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'date' => 'required',
            'hour' => 'required'
        ]);

        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->route_id = $request->route_id;
        $booking->seats = $request->seats;
        $booking->departure = $request->departure;
        $booking->arrival = $request->arrival;
        $booking->date = Route::date_fr_to_us($request->date);
        $booking->hour = $request->hour;
        $booking->save();

        $route = Route::find($request->route_id);
        $route->taken_seats = $route->taken_seats + $request->seats;
        $route->save();

        return redirect('/dashboard/bookings')->with('success', 'Réservation effectuée !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $route = Route::find($booking->route_id);

        // Check for correct user
        if (auth()->user()->id != $booking->user_id)
            return redirect('/dashboard/bookings')->with('error', 'Erreur : accès non autorisé !');

        $route->taken_seats -= $booking->seats;
        $route->save();

        $booking->delete();

        return redirect('/dashboard/bookings')->with('success', 'Véhicule supprimé !');
    }
}
