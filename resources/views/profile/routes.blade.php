@extends('layouts.app')

@section('title')
    myCar — Vos myCar
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Panel "Vos myCar" -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="material-icons">near_me</i>
                    Vos myCar
                </div>
                <br>
                <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="text-center">
                    <a href="/routes/create/1" class="btn btn-primary"><i class="material-icons">add_circle</i>&emsp;Créer un myCar</a>
                </div>

                <br>

                @if(count($routes) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Jour(s)</th>
                                <th>Horaires</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Étapes</th>
                                <th>Type</th>
                                <th>Véhicule</th>
                                <th>Bagages</th>
                                <th>Passagers max.</th>
                                <th>Réservations</th>
                                <th>Statut</th>
                                <th>Actions</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($routes as $route)
                                <?php $id = $route->id ?>
                                <tr>
                                    <td>
                                        <?php $days = $route->days($id) ?>
                                        @if(is_array($days))
                                            @foreach($days as $day => $value)
                                                @if($value == "1")
                                                    @if($day == 'mon')
                                                        Lun.<br>
                                                    @elseif($day =='tue')
                                                        Mar.<br>
                                                    @elseif($day =='wed')
                                                        Mer.<br>
                                                    @elseif($day =='thu')
                                                        Jeu.<br>
                                                    @elseif($day =='fri')
                                                        Ven.<br>
                                                    @elseif($day =='sat')
                                                        Sam.<br>
                                                    @else
                                                        Dim.
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $days }}
                                        @endif
                                    </td>

                                    <td>
                                        <?php $hours = $route->hours($id) ?>
                                        @if(is_array($hours))
                                            @foreach($hours as $day => $hour)
                                                @if($hour != 'null')
                                                    @if($day == 'mon')
                                                        {{ $hours['mon'] }}<br>
                                                    @elseif($day =='tue')
                                                        {{ $hours['tue'] }}<br>
                                                    @elseif($day =='wed')
                                                        {{ $hours['wed'] }}<br>
                                                    @elseif($day =='thu')
                                                        {{ $hours['thu'] }}<br>
                                                    @elseif($day =='fri')
                                                        {{ $hours['fri'] }}<br>
                                                    @elseif($day =='sat')
                                                        {{ $hours['sat'] }}<br>
                                                    @else
                                                        {{ $hours['sun'] }}<br>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $hours }}
                                        @endif
                                    </td>

                                    <td>{{ $route->departure($id) }}</td>

                                    <td>{{ $route->arrival($id) }}</td>

                                    <td>
                                        <?php $cpt = 0; ?>
                                        @foreach($route->steps($route->id) as $step)
                                            <?php $cpt++; ?>
                                            {{ '- '.$step }}
                                            @if($cpt < count($route->steps($route->id)))
                                                <br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $route->type == "0" ? "Récurrent" : "Ponctuel" }}</td>

                                    <td>{{ $route->numberplate($id) }}</td>


                                    <td>{{ $route->luggages == "0" ? "Non" : "Oui" }}</td>

                                    <td>{{ $route->seats }}</td>

                                    <td>{{ $route->taken_seats }}</td>

                                    <td>{{ $route->status == "0" ? "Attente" : ($route->status == "1" ? "Lancé" : "Terminé") }}</td>

                                    @if($route->status == 0)
                                        <td>
                                            {!! Form::open(['action' => ['RoutesController@changeState'], 'method' => 'POST']) !!}
                                            <input type="hidden" name="route_id" value="{{ $route->id }}">
                                            <button type="submit" class="btn btn-warning"><i class="material-icons">flight_takeoff</i>&emsp;&emsp;Démarrer</button>
                                            {!! Form::close() !!}
                                        </td>
                                    @elseif($route->status == 1)
                                        <td>
                                            {!! Form::open(['action' => ['RoutesController@changeState'], 'method' => 'POST']) !!}
                                            <input type="hidden" name="route_id" value="{{ $route->id }}">
                                            <button type="submit" class="btn btn-success"><i class="material-icons">check_circle</i>&emsp;&emsp;Terminer</button>
                                            {!! Form::close() !!}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bookedModal{{ $route->id }}"><i class="material-icons">supervisor_account</i>&emsp;Passagers</button>

                                        <div class="modal fade" id="bookedModal{{ $route->id }}" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Liste des passagers</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Passagers de ce trajet :</h4>

                                                        <?php
                                                            $bookings = \App\Booking::where('route_id',$route->id)->get();
                                                        ?>
                                                        @if(count($bookings) > 0)
                                                            <small>
                                                                Cliquez sur un mail pour contacter le passager.
                                                                <br>
                                                            </small>
                                                            @foreach($bookings as $booking)
                                                                - <a href="mailto:{{ \App\User::find($booking->user_id)->email }}">{{ \App\User::find($booking->user_id)->email }}</a><br>
                                                                &emsp;&emsp;<i class="material-icons">subdirectory_arrow_right</i> Monte à {{ $booking->departure }}<br>
                                                                &emsp;&emsp;<i class="material-icons">subdirectory_arrow_right</i> Descend à {{ $booking->arrival }}
                                                                <br>
                                                            @endforeach
                                                        @else
                                                            Pas de passagers pour ce trajet
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="material-icons">cancel</i>&emsp;Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($route->status != 2)
                                            {!! Form::open(['action' => ['RoutesController@destroy', $route->id], 'method' => 'POST']) !!}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <button type="submit" class="btn btn-danger"><i class="material-icons">delete</i>&emsp;&emsp;Supprimer</button>
                                            {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <h4>Vous n'avez pas de myCar.</h4>
                @endif
            </div>
        </div>
        </div>
    </div>
@endsection
