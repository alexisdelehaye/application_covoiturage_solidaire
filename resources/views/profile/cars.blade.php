@extends('layouts.app')

@section('title')
    myCar — Vos véhicules
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <!-- Panel "Vos véhicules" -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <i class="material-icons">local_taxi</i>
                        Vos véhicules
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center">
                            <a href="/cars/create" class="btn btn-primary"><i class="material-icons">add_circle</i>&emsp;Ajouter un véhicule</a>
                        </div>

                        <br>

                        @if(count($cars) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Immatriculation</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Couleur</th>
                                        <th>Passagers</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    @foreach($cars as $car)
                                        <tr>
                                            <td>{{ $car->numberplate }}</td>
                                            <td>{{ $car->brand }}</td>
                                            <td>{{ $car->model }}</td>
                                            <td>{{ ucfirst($car->color) }}</td>
                                            <td>{{ $car->seats }}</td>
                                            <td><a href="/cars/{{ $car->id }}/edit" class="btn btn-default"><i class="material-icons">edit</i>&emsp;&emsp;Éditer</a></td>

                                            <td>
                                                {!! Form::open(['action' => ['CarsController@destroy', $car->id], 'method' => 'POST']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                <button type="submit" class="btn btn-danger"><i class="material-icons">delete</i>&emsp;&emsp;Supprimer</button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @else
                            <h4>Vous n'avez pas de véhicule.</h4>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
