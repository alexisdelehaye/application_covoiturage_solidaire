@extends('layouts.app')

@section('title')
    myCar — Créer un myCar 2/4
@endsection

@section('scripts')
    <script type="text/javascript">
        var addNew = document.getElementById("addNew");

        function btnNext_clickHandler(event) {
            document.getElementById("addNew").value = "0";
            document.getElementById("form").submit();
        }

        function btnNew_clickHandler(event) {
            document.getElementById("addNew").value = "1";
            document.getElementById("form").submit();
        }
    </script>
@endsection

@section('content')
    <!-- Étape 2 -->
    @if(isset($errorcode))
        <div class="alert alert-danger">
            Veuillez sélectionner au moins une journée !
        </div>
    @endif

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
    </div>

    <div class="well">
        <h1>Créer un myCar : étape 2/4 — Ajoutez des points de passage</h1>
        <hr>
        {!!  Form::open(['url' => '/routes/create/3', 'method' => 'GET', 'enctype' => 'multipart/form-data', 'id' => 'form']) !!}
        <div class="form-group">

            <input type="hidden" name="departure" value="{{ $departure }}">
            <input type="hidden" name="arrival" value="{{ $arrival }}">
            <input type="hidden" name="car" value="{{ $car }}">
            <input type="hidden" name="luggages" value="{{ $luggages }}">
            <input type="hidden" name="type" value="{{ $type }}">

            @if(isset($steps))
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        {{ Form::label('steps', 'Points de passage dans l\'ordre') }}
                        <input class="form-control" value="{{ $formattedSteps }}" readonly>
                        <input type="hidden" name="steps" value="{{ $steps }}" readonly>
                    </div>
                </div>
                <br><br><br><br>
            @endif

            <div class="col-xs-12">
                <div class="col-xs-6">
                    {{ Form::label('step', 'Point de passage') }}
                    <div class="bfh-selectbox" id="step" data-name="step" data-value="Gare de Lille" data-filter="true">
                        @foreach($stops as $stop)
                            <div data-value="{{ $stop->name }}">{{ $stop->zip.' - '.$stop->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>


            <br>
            <br>
            <br>
            <br>
            <input type="hidden" name="addNew" id="addNew" value="depends">
            <div class="col-xs-12">
                <div class="col-xs-6 text-center">
                    <button id="btnNew" class="btn btn-success" onclick="btnNew_clickHandler(event);"><i class="material-icons">add_location</i>&emsp;Ajouter un nouveau point</button>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="col-xs-12 text-center">
                <div class="col-xs-6">
                    Ajoutez tous vos points de ramassage dans l'ordre de passage avant de valider.
                </div>
                <div class="col-xs-6">
                    <button id="btnNew" class="btn btn-primary" onclick="btnNext_clickHandler(event);"><i class="material-icons">playlist_add_check</i>&emsp;&emsp;Valider</button>
                </div>
            </div>
            <br>
            <br>
        </div>
        {!! Form::close() !!}
    </div>

@endsection