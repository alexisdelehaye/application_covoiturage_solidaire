<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Route;
use App\Car;
use App\Booking;
use App\Message;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $routes = Route::where('user_id', $user_id)->orderBy('status', 'asc')->orderBy('id', 'desc')->get();
        $cars = Car::where('user_id', $user_id)->orderBy('id', 'asc')->get();
        return view('dashboard')->with(['routes' => $routes, 'cars' => $cars]);
    }

    public function cars() {
        $user_id = auth()->user()->id;
        $cars = Car::where('user_id', $user_id)->orderBy('id', 'asc')->get();
        return view('profile.cars')
            ->with([
               'cars' => $cars
            ]);
    }

    public function routes() {
        $user_id = auth()->user()->id;
        $routes = Route::where('user_id', $user_id)->orderBy('status', 'asc')->orderBy('id', 'desc')->get();
        return view('profile.routes')
            ->with([
               'routes' => $routes
            ]);
    }

    public function bookings() {
        $user_id = auth()->user()->id;
        $bookings = Booking::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view('profile.bookings')
            ->with([
                'bookings' => $bookings
            ]);
    }

    public function messages(Request $request) {
        $user_id = auth()->user()->id;
        $messages = Message::where('receiver_id', $user_id)->orderBy('created_at', 'desc')->get();


        if($request->markread == "all") {
            foreach($messages as $message) {
                $message = Message::find($message->id);
                $message->read = 1;
                $message->save();
            }
        } else if($request->markread > 0) {
            $message = Message::find($request->markread);
            $message->read = 1;
            $message->save();
        }

        if($request->markunread > 0) {
            $message = Message::find($request->markunread);
            $message->read = 0;
            $message->save();
        }

        $messages = Message::where('receiver_id', $user_id)->orderBy('created_at', 'desc')->get();

        return view('profile.messages')
            ->with([
                'messages' => $messages
            ]);
    }
}
