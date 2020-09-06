@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials/Header/default', ['header' => 'Konto','subHeader' => 'Neues Konto'])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/account/create">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            @if ( Auth::user()->can('setGlobal', \App\Account::class) )
            <div class="form-group">
                <label for="global">Global</label>
                <input type="checkbox" name="global" id="global" value="1" class="form-check">
            </div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-success">Erstellen</button>
            </div>

        </form>
    </div>

</div>
@endsection
