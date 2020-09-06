@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', [
        'header' => 'Budgets',
        'subHeader' => 'Neues Budget'
    ])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/limit/create">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="" class="form-control">
            </div>
            <div class="form-group">
                <label for="account">Konto</label>
                <select name="account" id="account" class="form-control">
                    @foreach ( $accounts as $account )
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Kategorie</label>
                <select name="subject" id="subject" class="form-control">
                    <option value="0">Bitte wählen...</option>
                    @foreach ( $subjects as $subject )
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sumValFocus">Limit</label>
                <div class="input-group">
                    <input id="sumValFocus" type="text" name="sumPartA" placeholder="100" value="" class="form-control text-right">
                    <div class="input-group-text">,</div>
                    <input id="sumValTarget" maxlength="2" type="text" name="sumPartB" placeholder="0" value="0" class="form-control" style="width: 30px !important;">
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
