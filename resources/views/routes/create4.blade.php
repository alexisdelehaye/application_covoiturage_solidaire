@extends('layouts.app')

@section('title')
    myCar — Créer un myCar 4/4
@endsection

@section('content')
    <!-- Étape 3 -->
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
    </div>

    <div class="well">
        <h1>Créer un myCar : étape 4/4 — Choisissez vos horaires</h1>
        <hr>
        {!!  Form::open(['action' => 'RoutesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">

                <input type="hidden" name="departure" value="{{ $departure }}">
                <input type="hidden" name="arrival" value="{{ $arrival }}">
                <input type="hidden" name="car" value="{{ $car }}">
                <input type="hidden" name="luggages" value="{{ $luggages }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="steps" value="{{ $steps }}">
                <input type="hidden" name="seats" value="{{ $seats }}">

                <input type="hidden" name="day" value="{{ $day }}">
                <input type="hidden" name="mon" value="{{ $mon }}">
                <input type="hidden" name="tue" value="{{ $tue }}">
                <input type="hidden" name="wed" value="{{ $wed }}">
                <input type="hidden" name="thu" value="{{ $thu }}">
                <input type="hidden" name="fri" value="{{ $fri }}">
                <input type="hidden" name="sat" value="{{ $sat }}">
                <input type="hidden" name="sun" value="{{ $sun }}">

                @if($type == 0)
                    <input type="hidden" name="day_hour">

                    @if($mon == 1)
                        <div class="col-xs-12">
                            {{ Form::label('mon', 'Lundi') }}
                            <div class="bfh-timepicker" data-name="mon_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="mon_hour" value="null">
                    @endif
                    @if($tue == 1)
                        <div class="col-xs-12">
                            {{ Form::label('tue', 'Mardi') }}
                            <div class="bfh-timepicker" data-name="tue_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="tue_hour" value="null">
                    @endif
                    @if($wed == 1)
                        <div class="col-xs-12">
                            {{ Form::label('wed', 'Mercredi') }}
                            <div class="bfh-timepicker" data-name="wed_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="wed_hour" value="null">
                    @endif
                    @if($thu == 1)
                        <div class="col-xs-12">
                            {{ Form::label('thu', 'Jeudi') }}
                            <div class="bfh-timepicker" data-name="thu_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="thu_hour" value="null">
                    @endif
                    @if($fri == 1)
                        <div class="col-xs-12">
                            {{ Form::label('fri', 'Vendredi') }}
                            <div class="bfh-timepicker" data-name="fri_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="fri_hour" value="null">
                    @endif
                    @if($sat == 1)
                        <div class="col-xs-12">
                            {{ Form::label('sat', 'Samedi') }}
                            <div class="bfh-timepicker" data-name="sat_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="sat_hour" value="null">
                    @endif
                    @if($sun == 1)
                        <div class="col-xs-12">
                            {{ Form::label('sun', 'Dimanche') }}
                            <div class="bfh-timepicker" data-name="sun_hour"  data-time="07:00" ></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="sun_hour" value="null">
                    @endif
                @else
                    <div class="col-xs-12">
                        {{ Form::label('day', 'Heure du départ') }}
                        <div class="bfh-timepicker" data-name="day_hour"  data-time="07:00" ></div>
                        <input type="hidden" name="mon_hour" value="null">
                        <input type="hidden" name="tue_hour" value="null">
                        <input type="hidden" name="wed_hour" value="null">
                        <input type="hidden" name="thu_hour" value="null">
                        <input type="hidden" name="fri_hour" value="null">
                        <input type="hidden" name="sat_hour" value="null">
                        <input type="hidden" name="sun_hour" value="null">
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                @endif
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary"><i class="material-icons">note_add</i>&emsp;&emsp;Créer mon myCar</button>
                </div>
                <br>
            </div>
        {!! Form::close() !!}
    </div>

@endsection