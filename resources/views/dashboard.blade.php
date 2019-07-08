@extends('layouts.app')

@section('title')
    myCar — Tableau de bord
@endsection

<?php
    $nbCars = count(\App\Car::where('user_id', auth()->user()->id)->get());
    $nbMessages = count(\App\Message::where('read', 0)->where('receiver_id', auth()->user()->id)->get());
    $nbRoutes = count(\App\Route::where('status', 0)->where('user_id', auth()->user()->id)->get());
    $nbBookings = count(\App\Booking::where('user_id', auth()->user()->id)->get());
?>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Panel "Vos véhicules" -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="material-icons">dashboard</i>
                    Tableau de bord
                </div>

                <div class="panel-body text-center">
                    <div class="col-xs-6">
                        @if($nbCars == 0)
                            <p>Vous n'avez aucun véhicule ajouté.</p>
                        @else
                            <p>Vous avez <strong>{{ $nbCars }}</strong> véhicule(s).</p>
                        @endif

                    </div>
                    <div class="col-xs-6">
                        <a href="{{ url('/dashboard/cars') }}" class="btn btn-primary"><i class="material-icons">local_taxi</i>&emsp;&emsp;Vos véhicules</a>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="col-xs-6">
                        @if($nbMessages == 0)
                            <p>Vous n'avez aucun message non lu.</p>
                        @else
                            <p>Vous avez <strong>{{ $nbMessages }}</strong> message(s) non lu(s).</p>
                        @endif

                    </div>
                    <div class="col-xs-6">
                        <a href="{{ url('/dashboard/messages') }}" class="btn btn-primary"><i class="material-icons">message</i>&emsp;&emsp;Messagerie</a>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="col-xs-6">
                        @if($nbRoutes == 0)
                            <p>Vous n'avez aucun myCar en attente de départ.</p>
                        @else
                            <p>Vous avez <strong>{{ $nbCars }}</strong> myCar créé(s).</p>
                        @endif

                    </div>
                    <div class="col-xs-6">
                        <a href="{{ url('/dashboard/routes') }}" class="btn btn-primary"><i class="material-icons">near_me</i>&emsp;&emsp;Vos myCar</a>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="col-xs-6">
                        @if($nbBookings == 0)
                            <p>Vous n'avez aucune réservation.</p>
                        @else
                            <p>Vous avez <strong>{{ $nbBookings }}</strong> réservation(s).</p>
                        @endif
                    </div>
                    <div class="col-xs-6">
                        <a href="{{ url('/dashboard/bookings') }}" class="btn btn-primary"><i class="material-icons">book</i>&emsp;&emsp;Vos réservations</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
