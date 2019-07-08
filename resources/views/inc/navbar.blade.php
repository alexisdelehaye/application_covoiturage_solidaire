<html>

    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="logo-inline"><img class="logo d-inline" src="{{ asset('/img/mycar.png') }}">&emsp;myCar</span>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <ul class="nav navbar-nav">
                    <li><a href="/"><i class="material-icons">home</i>&emsp;&emsp;Accueil</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}"><i class="material-icons">person</i>&emsp;&emsp;Connexion</a></li>
                        <li><a href="{{ route('register') }}"><i class="material-icons">person_add</i>&emsp;&emsp;Inscription</a></li>
                        @else
                            <li><a href="{{ url('/dashboard/messages') }}"><i class="material-icons">message</i>&emsp;&emsp;Messagerie {{ count(\App\Message::where('receiver_id', auth()->user()->id)->where('read', 0)->where('receiver_id', auth()->user()->id)->get()) != 0 ? '('.count(\App\Message::where('read', 0)->where('receiver_id', auth()->user()->id)->get()).')' : '' }}</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="material-icons">account_circle</i>&emsp;&emsp;{{ Auth::user()->first_name." ".Auth::user()->last_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="/dashboard"><i class="material-icons">dashboard</i>&emsp;&emsp;Tableau de bord</a></li>
                                    <li><a href="/dashboard/bookings"><i class="material-icons">book</i>&emsp;&emsp;Vos réservations</a></li>
                                    <li><a href="/dashboard/routes"><i class="material-icons">near_me</i>&emsp;&emsp;Vos myCar</a></li>
                                    <li><a href="/dashboard/cars"><i class="material-icons">local_taxi</i>&emsp;&emsp;Vos véhicules</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="material-icons">exit_to_app</i>&emsp;&emsp;Déconnexion
                                        </a>


                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>



</html>