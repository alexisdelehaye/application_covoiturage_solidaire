@extends('layouts.app')

@section('title')
    myCar — Messagerie
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <!-- Panel "Vos myCar" -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="material-icons">inbox</i>
                    Boîte de réception
                </div>

                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-md-6 text-left">
                        {!! Form::open(['action' => ['DashboardController@messages'], 'method' => 'GET']) !!}
                            <input type="hidden" name="markread" value="all">
                            <button type="submit" class="btn btn-success"><i class="material-icons">drafts</i>&emsp;Tout marquer comme lu</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="/messages/create" class="btn btn-primary"><i class="material-icons">edit</i>&emsp;&emsp;Nouveau message</a>
                    </div>

                    <br>
                    <br>
                    <br>

                    @if(count($messages) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Expéditeur</th>
                                    <th>Objet</th>
                                    <th>Reçu le</th>
                                    <th>à</th>
                                    <th>Actions</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{ \App\User::find($message->sender_id)->id != 0 ? \App\User::find($message->sender_id)->first_name.' '.\App\User::find($message->sender_id)->last_name : "myCar" }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ \App\Route::date_us_to_fr(explode(' ', $message->created_at)[0]) }}</td>
                                        <td>{{ \App\Route::shorten_hour(explode(' ', $message->created_at)[1]) }}</td>
                                        <td text-center>
                                            @if($message->read == 0)
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#msgContent{{ $message->id }}"><i class="material-icons">mail</i>&emsp;Voir</button>
                                            @else
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#msgContent{{ $message->id }}"><i class="material-icons">drafts</i>&emsp;Voir</button>
                                            @endif
                                            <!-- FENÊTRE MODALE AVEC CONTENU DU MESSAGE -->
                                            <div class="modal fade" id="msgContent{{ $message->id }}" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">
                                                                <strong>De :</strong> {{ \App\User::find($message->sender_id)->first_name.' '.\App\User::find($message->sender_id)->last_name}}<br>
                                                                <strong>À :</strong> {{ auth()->user()->first_name.' '.auth()->user()->last_name }}<br>
                                                                <strong>Objet :</strong> {{ $message->subject }}
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $message->body }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            @if(\App\User::find($message->sender_id)->id != 0)
                                                                <div class="col-xs-6 text-left">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="material-icons">cancel</i>&emsp;Fermer</button>
                                                                </div>
                                                                <div class="col-xs-6 text-right">
                                                                    {!! Form::open(['action' => ['MessagesController@create'], 'method' => 'GET']) !!}
                                                                        <input type="hidden" name="sender_id" value="{{ $message->receiver_id }}">
                                                                        <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">
                                                                        <input type="hidden" name="subject" value="{{ 'Re: '.$message->subject }}">
                                                                        <button type="submit" class="btn btn-primary"><i class="material-icons">reply</i>&emsp;Répondre</button>
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            @else
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="material-icons">cancel</i>&emsp;Fermer</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($message->read == 0)
                                                {!! Form::open(['action' => ['DashboardController@messages'], 'method' => 'GET']) !!}
                                                    <input type="hidden" name="markread" value="{{ $message->id }}">
                                                    <button type="submit" class="btn btn-warning"><i class="material-icons">drafts</i>&emsp;Marquer comme lu</button>
                                                {!! Form::close() !!}
                                            @else
                                                {!! Form::open(['action' => ['DashboardController@messages'], 'method' => 'GET']) !!}
                                                    <input type="hidden" name="markunread" value="{{ $message->id }}">
                                                    <button type="submit" class="btn btn-warning"><i class="material-icons">mail</i>&emsp;Marquer comme non lu</button>
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {!! Form::open(['action' => ['MessagesController@destroy', $message->id], 'method' => 'POST']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                <button type="submit" class="btn btn-danger"><i class="material-icons">delete</i>&emsp;&emsp;Supprimer</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @else
                        <h4 style="padding: 5px 5px 5px 5px;">Vous n'avez pas de message reçu.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
