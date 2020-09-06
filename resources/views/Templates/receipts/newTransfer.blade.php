@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', [
        'header' => 'Belege',
        'subHeader' => 'Neuer Geldtransfer'
    ])

    @component('Partials/Form/formErrors', ['errors' => $errors])
    @endcomponent

    @component('Partials/Form/formStatus')
    @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/receipt/transfer">
            @csrf

            <div class="form-group">
                <label for="name">Bezeichnung</label>
                <input type="text" name="name" id="name" value="" class="form-control">
            </div>
            <div class="form-group">
                <label for="date">Datum</label>
                <input type="text" name="date" value="" class="datepicker form-control">
            </div>
            <div class="form-group">
                <label for="accountSource">von Konto</label>
                <select name="accountSource" class="form-control">
                    @foreach ( $accounts as $account )
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="accountTarget">an Konto</label>
                <select name="accountTarget" class="form-control">
                    @foreach ( $accounts as $account )
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sumValFocus">Betrag</label>
                <div class="input-group">
                    <input id="sumValFocus" type="text" name="sumPartA" placeholder="100" value="" class="form-control text-right">
                    <div class="input-group-text">,</div>
                    <input id="sumValTarget" maxlength="2" type="text" name="sumPartB" placeholder="0" value="" class="form-control" style="width: 30px !important;">
                    <div class="input-group-text">EUR</div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Erstellen</button>
            </div>

        </form>
    </div>

</div>
@endsection
