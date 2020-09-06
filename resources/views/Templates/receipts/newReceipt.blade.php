@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', [
        'header' => 'Belege',
        'subHeader' => 'Neuer Beleg'
    ])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    @component('Partials/Form/formStatus') @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/receipt/create">
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
                <label for="type">Belegart</label>
                <select name="type" id="type" class="form-control">
                    <option value="debit">Ausgabe</option>
                    <option value="credit">Einnahme</option>
                </select>
            </div>
            <div class="form-group">
                <label for="account">Konto</label>
                <select name="account" class="form-control">
                    @foreach ( $accounts as $account )
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Kategorie</label>
                <select name="subject" class="form-control">
                    @foreach ( $subjects as $subject )
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
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
