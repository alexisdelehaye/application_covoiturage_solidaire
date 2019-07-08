@extends('layouts.app')

@section('title')
    myCar — Covoiturage solidaire
@endsection

@section('content')

    <div class="jumbotron text-center">
        @if(Auth::guest())
                <h1>Bienvenue sur myCar!</h1>
                <p>Besoin d'une place ? Embarquez, c'est déjà prêt.</p>

                <p>
                    <a class="btn btn-primary btn-lg" href="/login" role="button"><i class="material-icons">person</i>&emsp;&emsp;Connexion</a>
                    <br><br>
                    <a class="btn btn-success btn-lg" href="/register" role="button"><i class="material-icons">person_add</i>&emsp;&emsp;Inscription</a>
                </p>
        @else
            <?php
                if(\App\User::find(Auth::user()->id)->registered == false) {
                    $msg = new \App\Message();
                    $msg->sender_id = 0;
                    $msg->receiver_id = Auth::user()->id;
                    $msg->subject = 'Bienvenue sur myCar !';
                    $msg->body = nl2br('Bienvenue sur myCar, '.Auth::user()->first_name.'. Si vous souhaitez proposer des trajets, vous pouvez commencer par ajouter votre véhicule dans la séction "Vos véhicules". Si vous souhaitez simplement rechercher un trajet, vous pouvez y aller. Rendez-vous sur l’accueil !');
                    $msg->read = 0;
                    $msg->save();

                    $user = Auth::user();
                    $user->registered = true;
                    $user->save();
                }
            ?>
            <h1>Bonjour, {{ Auth::user()->first_name }} !</h1>
            <br>
            <div class="text-center">
                <a href="/dashboard" class="btn btn-primary"><i class="material-icons">dashboard</i> Accéder au tableau de bord</a>
            </div>
        @endif
    </div>
    <hr>
    @include('inc.routesearch')


@endsection
