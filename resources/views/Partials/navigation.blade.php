<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @guest
                <li class="nav-item active">
                    <a class="nav-link" href="/login">Login<span class="sr-only">(current)</span></a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="/home">Home</a>
                </li>

                @if ( Auth::user()->can('list', \App\Receipt::class) || Auth::user()->can('create', \App\Receipt::class) )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Belege</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if ( Auth::user()->can('list', \App\Receipt::class) )
                                <a class="dropdown-item" href="/receipts">Anzeigen</a>
                            @endif
                            @if ( Auth::user()->can('create', \App\Receipt::class) )
                                <a class="dropdown-item" href="/receipt/newReceipt">Neuer Beleg</a>
                            @endif
                            @if ( Auth::user()->can('create', \App\Receipt::class) )
                                <a class="dropdown-item" href="/receipt/newTransfer">Neuer Geldtransfer</a>
                            @endif
                        </div>
                    </li>
                @endif

                @if ( Auth::user()->can('list', \App\Account::class) || Auth::user()->can('list', \App\Subject::class) || Auth::user()->can('list', \App\Limit::class) )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Verwaltung</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if ( Auth::user()->can('list', \App\Account::class) )
                                <a class="dropdown-item" href="/accounts">Konten</a>
                            @endif
                            @if ( Auth::user()->can('list', \App\Subject::class) )
                                <a class="dropdown-item" href="/subjects">Kategorien</a>
                            @endif
                            @if ( Auth::user()->can('list', \App\Limit::class) )
                                <a class="dropdown-item" href="/limits">Budgets</a>
                            @endif
                        </div>
                    </li>
                @endif

                @if ( Auth::user()->can('list', \App\User::class) || Auth::user()->can('list', \App\Role::class) )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rechte</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if ( Auth::user()->can('list', \App\User::class) )
                                <a class="dropdown-item" href="/users">Benutzer</a>
                            @endif
                            @if ( Auth::user()->can('list', \App\Role::class) )
                                <a class="dropdown-item" href="/roles">Gruppen</a>
                            @endif
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="/profile">Profil</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Logout') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Abmelden</a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>
