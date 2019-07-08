@extends('layouts.app')

@section('title')
    myCar — Éditer un véhicule
@endsection

@section('content')
    <div class="well">
        <h1>Éditer un véhicule</h1>
        <hr>
        {!!  Form::open(['action' => ['CarsController@update', $car->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{ Form::label('brand', 'Marque') }}
                {{ Form::text('brand', $car->brand, ['class' => 'form-control', 'placeholder' => 'Marque du véhicule']) }}
            </div>
            <div class="form-group">
                {{ Form::label('model', 'Modèle') }}
                {{ Form::text('model', $car->model, ['class' => 'form-control', 'placeholder' => 'Modèle du véhicule']) }}
            </div>
            <div class="form-group">
                {{ Form::label('color', 'Couleur') }}
                {{ Form::text('color', $car->color, ['class' => 'form-control', 'placeholder' => 'Couleur du véhicule']) }}
            </div>
            <div class="form-group">
                {{ Form::label('numberplate', 'Numéro d\'immatriculation') }}
                {{ Form::text('numberplate', $car->numberplate, ['class' => 'form-control', 'placeholder' => 'Numéro d\'immatriculation du véhicule']) }}
            </div>
            <div class="form-group">
                {{ Form::label('seats', 'Nombre de sièges passagers') }}
                {{ Form::text('seats', $car->seats, ['class' => 'form-control bfh-number', 'data-min' => 1, 'data-max' => 6]) }}
            </div>
            {{ Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    </div>
@endsection