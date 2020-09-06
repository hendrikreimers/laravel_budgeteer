@extends('Layouts.default')

@section('content')
    <div class="row">
        @include('Partials.Header.default', [
            'header' => 'Budgets',
            'subHeader' => $limit->name
        ])

        @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

        @component('Partials/Form/formStatus') @endcomponent
    </div>

    <div class="row">

        <div class="col-6 my-2">
            <form method="post" action="/limit/update/{{ $limit->id }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ $limit->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="account">Konto</label>
                    <select name="account" id="account" class="form-control">
                        @foreach ( $accounts as $account )
                            <option value="{{ $account->id }}" {{ ($account->id == $limit->account_id) ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject">Kategorie</label>
                    <select name="subject" id="subject" class="form-control">
                        <option value="0">Bitte wählen...</option>
                        @foreach ( $subjects as $subject )
                            <option value="{{ $subject->id }}" {{ ($subject->id == $limit->subject_id) ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sumValFocus">Limit</label>
                    <div class="input-group">
                        <input id="sumValFocus" type="text" name="sumPartA" placeholder="100" value="{{ $sumPartA }}" class="form-control text-right">
                        <div class="input-group-text">,</div>
                        <input id="sumValTarget" maxlength="2" type="text" name="sumPartB" placeholder="0" value="{{ $sumPartB }}" class="form-control" style="width: 30px !important;">
                        <div class="input-group-text">EUR</div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Aktualisieren</button>
                    <a href="/limit/delete/{{ $limit->id }}" type="button" class="btn btn-outline-danger"><span class="fa fa-trash fa-lg"></span> Löschen</a>
                </div>

            </form>
        </div>

    </div>

@endsection
