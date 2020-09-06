@extends('Layouts.default')

@section('content')
    <div class="row">
        <div class="col header-image">
            <div class="row align-items-center h-100 label-bg">
                <div class="col-6 mx-auto align-middle label">
                    <div><h1>Budgeteer</h1></div>
                    <p>Dein persönliches Haushaltsbuch</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-site-index row align-items-center mb-5 justify-content-center bg-secondary">
        <div class="col-6">

            <div class="my-5">
                <div class="card-body text-white">
                    <h5 class="card-title">Was ist Budgeteer?</h5>
                    <p class="card-text">
                        Dies ist ein privates Projekt. Es dient dazu, die Einnahmen (z. B. Gehalt)
                        und Ausgaben (z. B. Lebensmittel) zu erfassen und auszuwerten.
                    </p>
                </div>
            </div>

        </div>
    </div>
    <div class="row align-items-center my-5 justify-content-center">
        <div class="col-6">
            <div class="card-group">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Cookies</h5>
                        <p class="card-text">
                            Um unsere Webseite für Sie optimal zu gestalten und fortlaufend verbessern zu können,
                            verwenden wir Cookies. <a href="/datenschutzerklaerung">Mehr erfahren</a>
                        </p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Kontakt</h5>
                        <p class="card-text">
                            Interesse am Code, oder andere Fragen zu diesem Projekt?
                            Schau auf <a href="https://github.com/hendrikreimers">Github</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
