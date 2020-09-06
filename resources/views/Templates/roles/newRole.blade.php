@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', [
        'header' => 'Nutzergruppen',
        'subHeader' => 'Neue Gruppe'
    ])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/role/create">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="" class="form-control">
            </div>
            @foreach ( $fillable as $key )
                @if ( preg_match('/^(.*)_(view|list|create|update|delete|globals)$/i', $key) )
                    <div class="form-check my-2">
                        <input type="checkbox" value="1" id="{{ $key }}" name="rules[{{ $key }}]" class="form-check-input">
                        <label for="{{ $key }}" class="form-check-label">{{ $key }}</label>
                    </div>
                @endif
            @endforeach
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Erstellen</button>
            </div>

        </form>
    </div>

</div>
@endsection
