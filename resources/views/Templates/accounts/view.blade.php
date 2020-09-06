@extends('Layouts.default')

@section('content')
    <div class="row">
        @include('Partials.Header.default', [
            'header' => 'Konto',
            'subHeader' => $account->name
        ])

        @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

        @component('Partials/Form/formStatus') @endcomponent

        @if ( Auth::user()->can('update', $account) )
        <div class="col my-2 mr-4">
            <div class="text-right">
                <button class="btn btn-outline-secondary btn-sm mb-2" type="button" data-toggle="collapse" data-target="#collapse-form" aria-expanded="false" aria-controls="collapse-form">
                    Erweitert
                </button>
            </div>
            <div class="collapse" id="collapse-form">
                <form method="post" action="/account/update/{{ $account->id }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ $account->name }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Aktualisieren</button>
                        <a href="/account/delete/{{ $account->id }}" type="button" class="btn btn-outline-danger"><span class="fa fa-trash fa-lg"></span> Löschen</a>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col my-3">
            <span class="pr-5"><strong>Kontostand:</strong></span>
            <span>{{ money_format('%.2n', $account->receipts()->sum('credit') - $account->receipts()->sum('debit')) }} EUR</span>
        </div>
    </div>

    @component('Partials/Receipts/receiptTable', ['receipts' => $receipts, 'startDate' => $startDate, 'endDate' => $endDate])
    @endcomponent
@endsection
