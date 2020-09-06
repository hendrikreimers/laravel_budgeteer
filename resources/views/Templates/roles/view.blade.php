@extends('Layouts.default')

@section('content')
    <div class="row">
        @include('Partials.Header.default', [
            'header' => 'Nutzergruppen',
            'subHeader' => $role->name
        ])

        @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

        @component('Partials/Form/formStatus') @endcomponent
    </div>

    @if ( $role->read_only )
    <div class="row">
        <div class="col-6">
            <div class="alert alert-warning">Nur lesbar</div>
        </div>
    </div>
    @endif

    <div class="row">

        <div class="col-6 my-2">
            <form method="post" action="/role/update/{{ $role->id }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control-plaintext" readonly>
                </div>
                @foreach ( $roleFillables as $key => $val )
                    @if ( preg_match('/^(.*)_(view|list|create|update|delete|globals)$/i', $key) )
                        <div class="form-check my-2">
                            <input type="checkbox" value="1" id="{{ $key }}" name="rules[{{ $key }}]" class="form-check-input" {!! (!$role->read_only) ?: 'onclick="return false;"' !!} {{ ($val) ? 'checked' : '' }}>
                            <label for="{{ $key }}" class="form-check-label">{{ $key }}</label>
                        </div>
                    @endif
                @endforeach
                @if ( !$role->read_only )
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Aktualisieren</button>
                    <a href="/role/delete/{{ $role->id }}" type="button" class="btn btn-outline-danger"><span class="fa fa-trash fa-lg"></span> Löschen</a>
                </div>
                @endif

            </form>
        </div>

    </div>
@endsection
