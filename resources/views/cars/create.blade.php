@extends('layouts.app')

@section('title')
    myCar — Ajouter un véhicule
@endsection

@section('content')
    <div class="well">
        <h1>Ajouter un véhicule</h1>
        {!!  Form::open(['action' => 'CarsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{ Form::label('brand', 'Marque') }}
            {{ Form::text('brand', '', ['class' => 'form-control', 'placeholder' => 'Marque du véhicule']) }}
        </div>
        <div class="form-group">
            {{ Form::label('model', 'Modèle') }}
            {{ Form::text('model', '', ['class' => 'form-control', 'placeholder' => 'Modèle du véhicule']) }}
        </div>
        <div class="form-group">
            {{ Form::label('color', 'Couleur') }}
            {{ Form::text('color', '', ['class' => 'form-control', 'placeholder' => 'Couleur du véhicule']) }}
        </div>
        <div class="form-group">
            {{ Form::label('numberplate', 'Numéro d\'immatriculation') }}
            {{ Form::text('numberplate', '', ['class' => 'form-control', 'placeholder' => 'Numéro d\'immatriculation du véhicule']) }}
        </div>
        <div class="form-group">
            {{ Form::label('seats', 'Nombre de sièges passagers') }}
            {{ Form::text('seats', '', ['class' => 'form-control bfh-number', 'data-min' => 1, 'data-max' => 6]) }}
        </div>
        <button type="submit" class="btn btn-primary"><i class="material-icons">playlist_add</i>&emsp;&emsp;Ajouter un véhicule</button>
        {!! Form::close() !!}
    </div>

@endsection