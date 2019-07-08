@extends('layouts.app')

@section('title')
    myCar — Vos réservations
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

            <!-- Panel "Vos myCar" -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="material-icons">book</i>
                    Vos réservations
                    </div>

                    <div class="panel-body">

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(count($bookings) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>De</th>
                                        <th>à</th>
                                        <th>le</th>
                                        <th>à</th>
                                        <th>Places</th>
                                        <th>Statut</th>
                                        <th>Chauffeur</th>
                                        <th>Actions</th>
                                    </tr>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->departure }}</td>
                                        <td>{{ $booking->arrival }}</td>
                                        <td>{{ \App\Route::date_us_to_fr($booking->date) }}</td>
                                        <td>{{ \App\Route::shorten_hour($booking->hour) }}</td>
                                        <td>{{ $booking->seats }}</td>
                                        <td>{{ \App\Route::find($booking->route_id)->status == "0" ? "Attente" : (\App\Route::find($booking->route_id)->status == "1" ? "Lancé" : "Terminé") }}</td>
                                        <td><a href="mailto:{{ App\User::find($booking->user_id)->email }}">{{ App\User::find($booking->user_id)->email }}</a></td>
                                        <td>
                                            @if(\App\Route::find($booking->route_id)->status == 0)
                                                {!! Form::open(['action' => ['BookingsController@destroy', $booking->id], 'method' => 'POST']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                <button type="submit" class="btn btn-danger"><i class="material-icons">cancel</i>&emsp;&emsp;Annuler</button>
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </table>
                            </div>
                        @else
                            <h4 style="padding: 5px 5px 5px 5px;">Vous n'avez pas effectué de réservation.</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
