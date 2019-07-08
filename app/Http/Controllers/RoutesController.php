<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Route;

class RoutesController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::orderBy('created_at', 'desc')->paginate(10);
        return view('routes.index')->with('routes', $routes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = DB::table('cars')
            ->select('*')
            ->where('user_id', Auth::user()->id)
            ->orderBy('brand', 'ASC')
            ->get();

        $stops = RoutesController::getStops();

        return view('routes.create')->with(['stops' => $stops, 'cars' => $cars]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // L'étape 3 est terminée
        $this->validate($request, [
            // Attributs de l'étape 1
            'departure' => 'required',
            'arrival' => 'required',
            'car' => 'required',
            'luggages' => 'required',
            'type' => 'required',

            // Attributs de l'étape 2
            //'day' => 'required',
            'mon' => 'required',
            'tue' => 'required',
            'wed' => 'required',
            'thu' => 'required',
            'fri' => 'required',
            'sat' => 'required',
            'sun' => 'required',

            // Attributs de l'étape 3
            //'day_hour' => 'required',
            'mon_hour' => 'required',
            'tue_hour' => 'required',
            'wed_hour' => 'required',
            'thu_hour' => 'required',
            'fri_hour' => 'required',
            'sat_hour' => 'required',
            'sun_hour' => 'required',
        ]);

        // Récupération des attributs de l'étape 1
        $departure = $request->departure;
        $arrival = $request->arrival;
        $car_id = $request->car;
        $luggages = $request->luggages;
        $type = $request->type;

        // Récupération des attributs de l'étape 2
        $steps = $request->steps;

        // Récupération des attributs de l'étape 3
        $date = $request->day;
        if(isset($date))
            $date = Route::date_fr_to_us($date);
        $days = "mon=".$request->mon.
            ",tue=".$request->tue.
            ",wed=".$request->wed.
            ",thu=".$request->thu.
            ",fri=".$request->fri.
            ",sat=".$request->sat.
            ",sun=".$request->sun;
        $seats = $request->seats;

        // Récupération des attributs de l'étape 4
        $day_hour = $request->day_hour;
        $hours = "mon=".$request->mon_hour.
            ",tue=".$request->tue_hour.
            ",wed=".$request->wed_hour.
            ",thu=".$request->thu_hour.
            ",fri=".$request->fri_hour.
            ",sat=".$request->sat_hour.
            ",sun=".$request->sun_hour;


        // Création des attributs de trajet hors-étapes
        $status = 0;
        $user_id = auth()->user()->id;

        if(!empty($steps))
            $stops = $departure.','.$steps.','.$arrival;
        else
            $stops = $departure.','.$arrival;


        // Création de la route
        $route = new Route();
        $route->stops = $stops;
        $route->type = $type;
        $route->days = $days;
        $route->status = $status;
        $route->user_id = $user_id;
        $route->hours = $hours;
        $route->luggages = $luggages;
        $route->date = $date;
        $route->day_hour = $day_hour;
        $route->car_id = $car_id;
        $route->seats = $seats;
        $route->taken_seats = 0; // le nombre de sièges réservés, 0 de base

        $route->save();


        $msg = new \App\Message();
        $msg->sender_id = 0;
        $msg->receiver_id = $route->user_id;
        $msg->subject = 'Votre myCar a été créé !';
        if (count(explode(',', $route->stops)) > 2) {
            $msg->body = 'Votre trajet reliant '.$route->departure($route->id).' à '.$route->arrival($route->id).' a été créé. Il passe par '.implode(', ', explode(',', implode(',', array_slice(explode(',', $route->stops), 1, count(explode(',', $route->stops))-2)))).'. Il est maintenant ouvert à la réservation.';
        } else {
            $msg->body = 'Votre trajet reliant '.$route->departure($route->id).' à '.$route->arrival($route->id).' a été créé. Il est maintenant ouvert à la réservation.';
        }
        $msg->read = 0;
        $msg->save();


        return redirect('/dashboard')->with('success', 'Trajet créé !');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $route = Route::find($id);
        return view('routes.show')->with('route', $route);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'departure' => 'required',
            'arrival' => 'required',
            'date' => 'required',
            'time' => 'required',
            'seats' => 'required',
            'luggages' => 'required'
        ]);

        $departure = $request->departure;
        $arrival = $request->arrival;
        $date = $request->date;
        $time = $request->time;
        $seats = $request->seats;
        $luggages = $request->luggages;

        // Conversion de la date en format américain via une timestamp
        // pour afficher le jour en anglais en lowercase
        // ----
        $date_exploded = explode('/', $date);
        $d = $date_exploded[0];
        $m = $date_exploded[1];
        $y = $date_exploded[2];

        $timestamp = mktime(0, 0, 0, $m, $d, $y);

        $day = strtolower(date('D', $timestamp));
        // ----


        // Décrémentation de l'heure de 1 heure pour trouver les
        // trajets qui sont à partir de 1 heure avant l'heure indiquée
        // ----
        $time_array = explode(':', $time);
        $time_array[0] =
            ((int)$time_array[0] -1 < 0 ? "23" :
                ( ((int)$time_array[0]-1) < 10 ? "0".(string)((int)$time_array[0]-1) :
                    (string)((int)$time_array[0]-1) ) );

        $searchMOhour = $time_array[0];
        $searchMOminutes = $time_array[1];
        // ----

        $allRoutes = Route::select('*')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $routes = [];
        foreach($allRoutes as $route) {
            // Transformation des arrêts en liste pour parcours
            $stops_array = explode(',', $route->stops);

            // Transformation des jours en liste pour parcours
            $days_array = explode(',', $route->days);

            if (in_array($departure, $stops_array) && in_array($arrival, $stops_array) &&
                array_search($departure, $stops_array) < array_search($arrival, $stops_array)) {
                if ( ($route->type == 0 ? in_array($day.'=1', $days_array) : $route->date == $y.'-'.$m.'-'.$d) ) {

                    $routeTime = ( $route->type == 0 ? $route->hours($route->id)[$day] : $route->hours($route->id) );
                    $routeTime_array = explode(':', $routeTime);
                    $routeTimeHour = $routeTime_array[0];
                    $routeTimeMinutes = $routeTime_array[1];

                    if ($route->status == 0) {
                        if ( ($luggages == "1" ? $route->luggages == true : true) ) {
                            if ($route->seats - $route->taken_seats >= $seats) {
                                if ( ($routeTimeHour == $searchMOhour) ? $routeTimeMinutes >= $searchMOminutes : $routeTimeHour >= $searchMOhour ) {
                                    $routes[] = $route;
                                }
                            }
                        }
                    }
                }
            }
        }

        $stops = DB::table('stops')
            ->select('*')
            ->orderBy('zip', 'ASC')
            ->get();

        return view('routes.index')
            ->with(['stops' => $stops,
                'routes' => $routes,
                'departure' => $departure,
                'arrival' => $arrival,
                'date' => $date,
                'day' => $day,
                'time' => $time,
                'seats' => $seats,
                'luggages' => $luggages,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $route = Route::find($id);

        // Check for correct user
        if(auth()->user()->id != $route->user_id)
            return redirect('/routes')->with('error', 'Unauthorized access !');

        return view('routes.edit')->with('route', $route);
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
            'title' => 'required',
            'body' => 'required'
        ]);

        /*
        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        if ($request->hasFile('cover_image')) {

            if ($route->cover_image != 'null.png') {
                // Delete image
                Storage::delete('public/cover_images/'.$post->cover_image);
            }

        }
        */

        // Update route
        $route = Route::find($id);
        $route->stops = $request->input('stops');
        $route->days = $request->input('days');
        $route->hours = $request->input('hours');
        $route->user_id = auth()->user()->id;
        $route->status = 0; // statut = en cours
        $route->save();

        return redirect('/routes')->with('success', 'Route updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $route = Route::find($id);

        // Check for correct user
        if (auth()->user()->id != $route->user_id)
            return redirect('/dashboard')->with('error', 'Erreur : accès non autorisé !');

        /*
        if ($route->cover_image != 'null.png') {
            // Delete image
            Storage::delete('public/cover_images/'.$route->cover_image);
        }
        */

        $bookings = \App\Booking::where('route_id', $route->id);
        foreach($bookings as $booking) {
            $msg = new \App\Message();
            $msg->sender_id = 0;
            $msg->receiver_id = $booking->user_id;
            $msg->subject = 'Votre myCar a été supprimé !';
            $msg->body = nl2br(\App\User::find($route->user_id)->first_name.' '.\App\User::find($route->user_id)->last_name.', le chauffeur du trajet reliant '.$route->departure($route->id).' à '.$route->arrival($route->id).' a décidé d\'annuler son trajet. Vous pouvez le contacter pour en savoir plus. - L\'équipe myCar');
            $msg->save();
        }

        $route->delete();

        return redirect('/dashboard')->with('success', 'Trajet supprimé !');
    }


    public function changeState(Request $request)
    {
        $route = Route::find($request->route_id);

        $status = $route->status;

        if ($status == 0) {
            $route->status = 1;
            $route->save();

            $bookings = \App\Booking::where('route_id', $route->id);

            foreach($bookings as $booking) {
                $msg = new \App\Message();
                $msg->sender_id = 0;
                $msg->receiver_id = $booking->user_id;
                $msg->subject = 'Votre chauffeur a démarré !';
                $msg->body = 'Le chauffeur de votre trajet reliant '.$route->departure($route->id).' à '.$route->arrival($route->id).' a démarré. Il va bientôt arriver. Soyez à l\'heure !';
                $msg->save();
            }

            return redirect('/dashboard/routes')->with('success', "Trajet lancé ! Vous pouvez le trouver sous vos myCar en attente pour le terminer.");
        } else if ($status == 1) {
            $route->status = 2;
            $route->save();

            $bookings = \App\Booking::where('route_id', $route->id);

            foreach($bookings as $booking) {
                $msg = new \App\Message();
                $msg->sender_id = 0;
                $msg->receiver_id = $booking->user_id;
                $msg->subject = 'Votre chauffeur a terminé son trajet !';
                $msg->body = nl2br("Le chauffeur de votre trajet reliant ".$route->departure($route->id)." à ".$route->arrival($route->id)." a terminé son trajet. Si vous avez apprécié son service, n'hésitez pas à lui envoyer un message ! - L'équipe myCar");
                $msg->save();
            }
            return redirect('/dashboard/routes')->with('success', "Trajet terminé !");
        } else
            return redirect('/dashboard/routes');

    }
}
