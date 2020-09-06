@extends('Layouts.default')

@section('content')
    <div class="row">
        @include('Partials.Header.default', [
            'header' => 'Belege',
            'subHeader' => $receipt->name
        ])

        @component('Partials/Form/formErrors', ['errors' => $errors])
        @endcomponent

        @component('Partials/Form/formStatus')
        @endcomponent
    </div>

    <div class="row">

        <div class="col-6 my-2">
            <form method="post" action="/receipt/update/{{ $receipt->id }}">
                @csrf

                <div class="form-group">
                    <label for="name">Bezeichnung</label>
                    <input type="text" name="name" id="name" value="{{ $receipt->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Datum</label>
                    <input type="text" name="date" value="{{ strftime('%d.%m.%Y', $receipt->date) }}" class="datepicker form-control">
                </div>
                <div class="form-group">
                    <label for="type">Belegart</label>
                    <select name="type" id="type" class="form-control">
                        <option value="debit" {{ ($receipt->debit > 0) ? 'selected' : '' }}>Ausgabe</option>
                        <option value="credit" {{ ($receipt->credit > 0) ? 'selected' : '' }}>Einnahme</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="account">Konto</label>
                    <select name="account" class="form-control">
                        @foreach ( $accounts as $account )
                            <option value="{{ $account->id }}" {{ ($receipt->account_id == $account->id) ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject">Kategorie</label>
                    <select name="subject" class="form-control">
                        @foreach ( $subjects as $subject )
                            <option value="{{ $subject->id }}" {{ ($receipt->subject_id == $subject->id) ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sumValFocus">Betrag</label>
                    <div class="input-group">
                        <input id="sumValFocus" type="text" name="sumPartA" placeholder="100" value="{{ $sumPartA }}" class="form-control text-right">
                        <div class="input-group-text">,</div>
                        <input id="sumValTarget" maxlength="2" type="text" name="sumPartB" placeholder="0" value="{{ $sumPartB }}" class="form-control" style="width: 30px !important;">
                        <div class="input-group-text">EUR</div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Aktualisieren</button>
                    <a href="/receipt/delete/{{ $receipt->id }}" type="button" class="btn btn-outline-danger"><span class="fa fa-trash fa-lg"></span> Löschen</a>
                </div>

            </form>
        </div>

    </div>
@endsection
