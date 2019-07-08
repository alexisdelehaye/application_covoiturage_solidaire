
@extends('layouts.app')

@section('title')
    myCar — Résultats de recherche
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection

@section('content')
    @include('inc.routesearch')
    <hr>
    <h1>Résultats de votre recherche</h1>

    @if( count($routes) > 0)
        @foreach($routes as $route)
            <div class="well">
                <div class="row">
                    <!--
                    <div class="col-md-4 col-sm-4">
                        <img style="width: 100%" src="/storage/cover_images/{ { //$routes->cover_image }}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                    </div>
                    -->
                    <div style="margin-left: 1em">
                        <?php
                            $steps = [];
                            foreach($route->stops($route->id) as $stop) {
                                if ($stop != $route->stops($route->id)[0] && $stop != $route->stops($route->id)[count($route->stops($route->id))-1])
                                    $steps[] = $stop;
                            }
                        ?>
                        @if($departure == $route->departure($route->id))
                            <h3>
                                <i class="material-icons" style="font-size: 1.5em;">person_pin_circle</i>
                                <span class="text-success" style=" font-weight: bold;">
                                    {{ ( $route->type == 0 ? $route->hours($route->id)[$day] : $route->hours($route->id) ).' ' }}
                                    <i class="material-icons">navigate_next</i>{{ ' '.$route->departure($route->id).' ' }}
                                </span>
                            </h3>
                        @else
                            <h3>
                                <i class="material-icons" style="font-size: 1.5em;">person_pin_circle</i>
                                {{ ( $route->type == 0 ? $route->hours($route->id)[$day] : $route->hours($route->id) ).' ' }}
                                <i class="material-icons">navigate_next</i>{{ ' '.$route->stops($route->id)[0].' ' }}
                            </h3>
                        @endif

                        <h6><br></h6>

                        @if(count($steps) > 0)
                            @foreach($steps as $step)
                                @if($step == $departure || $step == $arrival)
                                    <h4 style="margin-left: 2em;"><i class="material-icons">subdirectory_arrow_right</i><span class="text-success" style="font-weight: bold;"><span style="text-decoration: underline">00:00</span><i class="material-icons">navigate_before</i>{{ ' '.$step }}</span></h4>
                                @else
                                    <h4 style="margin-left: 2em"><i class="material-icons">subdirectory_arrow_right</i>00:00<i class="material-icons">navigate_before</i>{{ ' '.$step }}</h4>
                                @endif
                            @endforeach
                        @else
                                <h4 style="margin-left: 2em;"><i class="material-icons" style="vertical-align: middle;">info</i>&emsp;Trajet direct</h4>
                        @endif

                        @if($arrival == $route->arrival($route->id))
                            <h3>
                                <i class="material-icons" style="font-size: 1.5em;">place</i>
                                <span class="text-success" style="font-weight: bold;">
                                    00:00
                                    <i class="material-icons">navigate_next</i>{{ ' '.$route->arrival($route->id).' ' }}
                                </span>
                            </h3>
                        @else
                            <h3>
                                <i class="material-icons" style="font-size: 1.5em;">place</i>
                                00:00
                                <i class="material-icons">navigate_next</i>
                                {{ ' '.$route->stops($route->id)[count($route->stops($route->id))-1].' ' }}
                            </h3>
                        @endif

                        <h6><br></h6>

                            <h5><u>Places restantes :</u> {{ $route->seats - $route->taken_seats }}</h5>
                        <h5><u>Accepte les bagages :</u> {{ $route->luggages == 0 ? "Non" : "Oui" }}</h5>
                        <h5><u>Véhicule :</u> {{ \App\Car::name($route->car_id) }}</h5>
                        <div class="col-xs-6">
                            <small>
                                Publié le {{ $route->created_at }}
                                <br>
                                par <strong>{{ $route->user->first_name.' '.$route->user->last_name }}</strong>
                            </small>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal"><i class="material-icons">bookmark</i>&emsp;Réserver</button>
                        </div>

                        <div class="modal fade" id="confirmModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Confirmer la réservation</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Réservation : </h4><small><br></small>
                                        <strong>
                                            {{ $departure.' ' }}<i class="material-icons">navigate_next</i>{{' '.$arrival}}<br>
                                            Départ à <u>00:00</u><br>
                                            {{ $seats.($seats == 1 ? " place" : " places") }}<br><br>
                                        </strong>
                                        Après confirmation, un mail sera envoyé au chauffeur pour l'informer de la réservation.
                                        <br><br>
                                        N'oubliez pas de vérifier vos mails (même les spams) le jour du départ. Un mail vous sera envoyé lors du départ du départ du chauffeur.
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-xs-6 text-left">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="material-icons">cancel</i>&emsp;Annuler</button>
                                        </div>
                                        {!! Form::open(['action' => ['BookingsController@store'], 'method' => 'POST']) !!}
                                            <input type="hidden" name="user_id" value="{{ $route->user_id }}">
                                            <input type="hidden" name="route_id" value="{{ $route->id }}">
                                            <input type="hidden" name="seats" value="{{ $seats }}">
                                            <input type="hidden" name="departure" value="{{ $departure }}">
                                            <input type="hidden" name="arrival" value="{{ $arrival }}">
                                            <input type="hidden" name="date" value="{{ $date }}">
                                            <input type="hidden" name="hour" value="{{ $time }}">
                                            <button type="submit" class="btn btn-success"><i class="material-icons">check_circle</i>&emsp;Confirmer</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>Aucun myCar ne correspond à votre recherche.</p>
    @endif
@endsection