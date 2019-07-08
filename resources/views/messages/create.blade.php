@extends('layouts.app')

@section('title')
    myCar — Messagerie
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <!-- Panel "Vos myCar" -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="material-icons">edit</i>
                    Rédiger un nouveau message
                </div>

                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <form action="{{ url('/dashboard/messages/store') }}" method="GET">
                            <div class="col-xs-1">
                                {{ Form::label('receiver_id', 'À : ') }}
                            </div>
                            <div class="col-xs-11">
                                <?php
                                $users = \App\User::all();
                                ?>
                                <div class="bfh-selectbox" id="receiver_id" data-name="receiver_id" data-value="{{ isset($receiver_id) ? $receiver_id : (count($users) > 0 ? $users[0]->id : '')  }}" data-filter="true">
                                    @foreach($users as $user)
                                        @if($user->id != auth()->user()->id && $user->id != 0)
                                            <div data-value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <br>
                            <br>
                            <br>

                            <div class="col-xs-1">
                                {{ Form::label('subject', 'Objet') }}
                            </div>
                            <div class="col-xs-11">
                                <input class="form-control" name="subject" value="{{ isset($subject) ? $subject : '' }}" placeholder="Objet">
                            </div>

                            <br>
                            <br>
                            <br>

                            <div class="col-xs-12">
                                {{ Form::label('body', 'Corps du message') }}
                            </div>
                            <div class="col-xs-12">
                                <textarea rows=5 class="form-control" name="body" placeholder="Corps du message"></textarea>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                            <div class="col-md-12 text-right">
                                <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-success">Envoyer&emsp;&emsp;<i class="material-icons">send</i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
