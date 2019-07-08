<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@index');

Route::post('/routes/changeState', 'RoutesController@changeState');

Route::get('/routes/create/1', 'RoutesController@create');

Route::get('/routes/create/2', function(\Illuminate\Http\Request $request) {
    // L'étape 1 est terminée
    /*
    $routeController = new \App\Http\Controllers\RoutesController();
    $routeController->validate($request, [
        // Attributs de l'étape 1
        'departure' => 'required',
        'arrival' => 'required',
        'car' => 'required',
        'luggages' => 'required',
        'type' => 'required',
        //'steps' => 'required'
    ]);
    */

    $stops = DB::table('stops')
        ->select('*')
        ->orderBy('zip', 'ASC')
        ->get();



    // Passage à l'étape 2
    return view('routes.create2')->with([
        // Attributs de l'étape 1
        'stops' => $stops,
        'departure' => $request->departure,
        'arrival' => $request->arrival,
        'car' => $request->car,
        'luggages' => $request->luggages,
        'type' => $request->type,
        'steps' => "",
        'formattedSteps' => ""
    ]);
});

Route::get('/routes/create/3', function(\Illuminate\Http\Request $request) {
    // L'étape 2 est terminée
    /*
    $routeController = new \App\Http\Controllers\RoutesController();
    $routeController->validate($request, [
        // Attributs de l'étape 1
        'departure' => 'required',
        'arrival' => 'required',
        'car' => 'required',
        'luggages' => 'required',
        'type' => 'required',
        //'steps' => 'required'
    ]);
    */

    if ($request->addNew == 1) {
        $steps = "".$request->steps;
        $step = $request->step;
        $array = explode(',', $steps);
        if(isset($step) && $step != $request->departure && $step != $request->arrival) {
            if (!in_array($step, $array)) {
                if( count($array) == 1 && empty($array[0]) )
                    $steps .= $step;
                else
                    $steps .= ','.$step;
            }
        }
        $array = explode(',', $steps);
        $formattedSteps = implode(', ', $array);

        $stops = DB::table('stops')
            ->select('*')
            ->orderBy('zip', 'ASC')
            ->get();

        return view('routes.create2')->with([
            // Attributs de l'étape 1
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'car' => $request->car,
            'luggages' => $request->luggages,
            'type' => $request->type,
            'stops' => $stops,
            'steps' => $steps,
            'formattedSteps' => $formattedSteps
        ]);
    }

    // Passage à l'étape 3
    return view('routes.create3')->with([
        // Attributs de l'étape 1
        'departure' => $request->departure,
        'arrival' => $request->arrival,
        'car' => $request->car,
        'luggages' => $request->luggages,
        'type' => $request->type,
        'steps' => $request->steps,
    ]);
});


Route::get('/routes/create/4', function(\Illuminate\Http\Request $request) {
    // L'étape 3 est terminée
    //return (string)isset($request->departure);

    /*
    $routeController = new \App\Http\Controllers\RoutesController();
    $routeController->validate($request, [
        // Attributs de l'étape 1
        'departure' => 'required',
        'arrival' => 'required',
        'car' => 'required',
        'luggages' => 'required',
        'type' => 'required',
        //'steps' => 'required'

        // Attributs de l'étape 2
        'day' => 'required',
        'mon' => 'required',
        'tue' => 'required',
        'wed' => 'required',
        'thu' => 'required',
        'fri' => 'required',
        'sat' => 'required',
        'sun' => 'required'
    ]);
    */

    // Si aucune journée n'a été choisie
    if(!isset($request->day) &&
        $request->mon == 0 &&
        $request->tue == 0 &&
        $request->wed == 0 &&
        $request->thu == 0 &&
        $request->fri == 0 &&
        $request->sat == 0 &&
        $request->sun == 0)

        // Alors on retourne la même page
        return view('routes.create3')->with([
            'errorcode' => 1, // On crée un code d'erreur, peu importe la valeur, qui affiche un message d'erreur (inc.messages ne fonctionne pas ici)
            // On renvoie les valeurs issues de l'étape 1
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'car' => $request->car,
            'luggages' => $request->luggages,
            'type' => $request->type,
            'steps' => $request->steps,
            'seats' => $request->seats
        ]);



    // Passage à l'étape 4
    return view('routes.create4')->with([
        // Attributs de l'étape 1
        'departure' => $request->departure,
        'arrival' => $request->arrival,
        'car' => $request->car,
        'luggages' => $request->luggages,
        'type' => $request->type,
        'steps' => $request->steps,
        'seats' => $request->seats,

        // Attributs de l'étape 2
        'day' => $request->day,
        'mon' => $request->mon,
        'tue' => $request->tue,
        'wed' => $request->wed,
        'thu' => $request->thu,
        'fri' => $request->fri,
        'sat' => $request->sat,
        'sun' => $request->sun
    ]);
});

Route::get('/dashboard/messages/store', 'MessagesController@store');

Route::resource('routes', 'RoutesController');
Route::resource('cars', 'CarsController');
Route::resource('bookings', 'BookingsController');
Route::resource('messages', 'MessagesController');

Route::post('/search', 'RoutesController@search');

Route::post('/cars/{car}', 'CarsController@update');


Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('home');
Route::get('/dashboard/cars', 'DashboardController@cars');
Route::get('/dashboard/routes', 'DashboardController@routes');
Route::get('/dashboard/bookings', 'DashboardController@bookings');
Route::get('/dashboard/messages', 'DashboardController@messages');
