@extends('layouts.app')

@section('title')
    myCar — Créer un myCar 3/4
@endsection

@section('content')
    <!-- Étape 2 -->
    @if(isset($errorcode))
        <div class="alert alert-danger">
            Veuillez sélectionner au moins une journée !
        </div>
    @endif

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
    </div>

    <div class="well">
        <h1>Créer un myCar : étape 3/4 — Choisissez vos jours/dates</h1>
        <hr>
        {!!  Form::open(['url' => '/routes/create/4', 'method' => 'GET', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">

                <input type="hidden" name="departure" value="{{ $departure }}">
                <input type="hidden" name="arrival" value="{{ $arrival }}">
                <input type="hidden" name="car" value="{{ $car }}">
                <input type="hidden" name="luggages" value="{{ $luggages }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="steps" value="{{ $steps }}">

                @if($type == 0)
                    <input type="hidden" name="day">

                    <div class="col-xs-12">
                        {{ Form::label('mon', 'Lundi') }}
                        <div class="bfh-selectbox" id="mon" data-name="mon" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="col-xs-12">
                        {{ Form::label('tue', 'Mardi') }}
                        <div class="bfh-selectbox" id="tue" data-name="tue" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="col-xs-12">
                        {{ Form::label('wed', 'Mercredi') }}
                        <div class="bfh-selectbox" id="wed" data-name="wed" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="col-xs-12">
                        {{ Form::label('thu', 'Jeudi') }}
                        <div class="bfh-selectbox" id="thu" data-name="thu" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="col-xs-12">
                        {{ Form::label('fri', 'Vendredi') }}
                        <div class="bfh-selectbox" id="fri" data-name="fri" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="col-xs-12">
                        {{ Form::label('sat', 'Samedi') }}
                        <div class="bfh-selectbox" id="sat" data-name="sat" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="col-xs-12">
                        {{ Form::label('sun', 'Dimanche') }}
                        <div class="bfh-selectbox" id="sun" data-name="sun" data-value="0">
                            <div data-value="0">Non</div>
                            <div data-value="1">Oui</div>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12">
                        {{ Form::label('day', 'Jour du départ') }}
                        <div class="bfh-datepicker" data-name="day" data-date="today" data-format="d/m/y" data-min="today"></div>
                    </div>
                        <input type="hidden" name="mon" value="0">
                        <input type="hidden" name="tue" value="0">
                        <input type="hidden" name="wed" value="0">
                        <input type="hidden" name="thu" value="0">
                        <input type="hidden" name="fri" value="0">
                        <input type="hidden" name="sat" value="0">
                        <input type="hidden" name="sun" value="0">
                @endif
                <br><br><br><br>
                <div class="col-xs-12">
                    {{ Form::label('seats', 'Nombre de passagers que vous acceptez') }}
                    <input type="text" class="form-control bfh-number" name="seats" data-value=1 data-min=1 data-max={{ App\Car::find($car)->seats }}>
                </div>
                <br><br><br><br>
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary">Étape suivante<i class="material-icons">navigate_next</i></button>
                </div>
                <br>
            </div>
        {!! Form::close() !!}
    </div>

@endsection