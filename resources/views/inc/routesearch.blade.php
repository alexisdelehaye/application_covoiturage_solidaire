<?php
    $stops = \App\Http\Controllers\RoutesController::getStops();
?>

<div class="well">
    {!!  Form::open(['action' => ['RoutesController@search'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            <h3><i class="material-icons" style="font-size: 1.2em;">search</i> Rechercher un trajet</h3>
            <hr>

            <div class="col-xs-6">
                {{ Form::label('departure', 'Lieu de départ') }}
            </div>
            <div class="col-xs-6">
                {{ Form::label('arrival', 'Lieu d\'arrivée') }}
            </div>
            <br>
            <div class="col-xs-6">
                <div class="bfh-selectbox" id="departure" data-name="departure" data-value="{{ isset($departure) ? $departure : 'Gare de Lens' }}" data-filter="true">
                    @foreach($stops as $stop)
                        <div data-value="{{ $stop->name }}">{{ $stop->zip.' - '.$stop->name }}</div>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-6">
                <div class="bfh-selectbox" id="arrival" data-name="arrival" data-value="{{ isset($arrival) ? $arrival : 'Mairie de Lens' }}"  data-filter="true">
                    @foreach($stops as $stop)
                        <div data-value="{{ $stop->name }}">{{ $stop->zip.' - '.$stop->name }}</div>
                    @endforeach
                </div>
            </div>

            <br>
            <br>
            <br>

            <div class="col-xs-6">
                {{ Form::label('day', 'Jour de départ') }}
            </div>
            <div class="col-xs-6">
                {{ Form::label('time', 'Heure de départ') }}
            </div>
            <br>
            <div class="col-xs-6 bfh-datepicker" data-name="date" data-date="{{ isset($date) ? $date : 'today' }}" data-format="d/m/y" data-min="today">
            </div>
            <div class="col-xs-6 bfh-timepicker" data-name="time"  data-time="{{ isset($time) ? $time : '07:00' }}" >
            </div>

            <br>
            <br>
            <br>

            <div class="col-xs-6">
                {{ Form::label('seats', 'Nombre de places') }}
            </div>
            <div class="col-xs-6">
                {{ Form::label('luggages', 'Avez-vous besoin de bagages ?') }}
            </div>
            <div class="col-xs-6">
                <input type="text" class="form-control bfh-number" name="seats" value="{{ isset($seats) ? $seats : '1' }}" data-min=1 data-max=6>
            </div>
            <div class="col-xs-6">
                <div class="bfh-selectbox" data-value="{{ isset($luggages) ? $luggages : '0' }}" data-name="luggages">
                    <div data-value="0">Non</div>
                    <div data-value="1">Oui</div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-xs-12 text-center">
                <button type="submit" class="btn btn-success"><i class="material-icons">search</i>&emsp;&emsp;Rechercher un myCar</button>
            </div>
            <br>

        </div>

    {!! Form::close() !!}
</div>
