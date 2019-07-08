@extends('layouts.app')

@section('title')
    myCar — Créer un myCar 1/4
@endsection

<?php
    $stops = \App\Http\Controllers\RoutesController::getStops();
?>

@section('content')
    <!-- Étape 1 -->
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
    </div>

    <div class="well">
        <h1>Créer un myCar : étape 1/4 — Caractéristiques du trajet</h1>
        <hr>
        {!!  Form::open(['url' => '/routes/create/2', 'method' => 'GET', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">

                <div class="col-xs-6">
                    {{ Form::label('departure', 'Lieu de départ') }}
                    <div class="bfh-selectbox" id="departure" data-name="departure" data-value="Gare de Lille" data-filter="true">
                        @foreach($stops as $stop)
                            <div data-value="{{ $stop->name }}">{{ $stop->zip.' - '.$stop->name }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-6">
                    {{ Form::label('arrival', 'Lieu d\'arrivée') }}
                    <div class="bfh-selectbox" id="arrival" data-name="arrival" data-value="Gare de Lens"  data-filter="true">
                        @foreach($stops as $stop)
                            <div data-value="{{ $stop->name }}">{{ $stop->zip.' - '.$stop->name }}</div>
                        @endforeach
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="col-xs-6">
                    {{ Form::label('car', 'Véhicule du trajet') }}
                    @if(count($cars) > 0)
                        <div class="bfh-selectbox" id="car" data-name="car" data-value="{{ $cars[0]->id }}">
                            @foreach($cars as $car)
                                <div data-value="{{ $car->id }}">{{ $car->brand.' '.$car->model.', '.$car->color }}</div>
                            @endforeach
                        </div>
                    @else
                        <br>Vous n'avez pas de véhicule.&emsp;&emsp;<a href="/cars/create" class="btn btn-warning">Ajouter un véhicule</a>
                    @endif
                </div>
                <div class="col-xs-6">
                    {{ Form::label('luggages', 'Acceptez-vous les bagages ?') }}
                    @if(count($cars) > 0)
                        <div class="bfh-selectbox" id="luggages" data-name="luggages" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    @else
                        <br>Vous n'avez pas de véhicule.&emsp;&emsp;<a href="/cars/create" class="btn btn-warning">Ajouter un véhicule</a>
                    @endif

                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="col-xs-12">
                    {{ Form::label('type', 'Type de trajet') }}
                </div>
                <div class="col-xs-6">
                    <div class="bfh-selectbox" id="type" data-name="type" data-value="0">
                        <div data-value="0">Récurrent (ex. <i>tous les lundi de chaque semaine</i>)</div>
                        <div data-value="1">Ponctuel (une fois de temps en temps)</div>
                    </div>
                </div>
                @if(count($cars) > 0)
                    <div class="col-xs-6 text-center">
                        <button type="submit" class="btn btn-primary">Étape suivante<i class="material-icons">navigate_next</i></button>
                    </div>
                @endif
            </div>
            <br><br>
            {!! Form::close() !!}
    </div>

@endsection