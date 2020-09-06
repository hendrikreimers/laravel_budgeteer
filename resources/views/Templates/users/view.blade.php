@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', ['header' => 'Benutzer'])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    @component('Partials/Form/formStatus') @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/user/update/{{ $user->id }}">
            @csrf

            @if ( Auth::user()->id !== $user->id )
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="disabled" id="disabled" value="1" {{ ( !$user->disabled ) ?: 'checked="checked"' }}></td>
                    <label for="disabled" class="form-check-label">Deaktiviert</label>
                </div>
            </div>
            @endif
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control-plaintext" readonly>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="text" name="email" id="email" value="{{ $user->email }}" class="form-control-plaintext" readonly><br>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Passwort" class="form-control" /><br>
                <input type="password" name="password_confirmation" placeholder="Passwort wiederholen" class="form-control" />
            </div>
            <div class="form-group">
                <label for="role">Gruppe</label>
                @if ( Auth::user()->id === $user->id )
                    <input type="text" value="{{ $user->roles()->first()->name }}" class="form-control-plaintext" readonly>
                @else
                    <select name="role" id="role" class="form-control">
                        @foreach ( $roles as $role )
                            <option value="{{ $role->id }}" {{ ($role->id == $user->roles()->first()->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Aktualisieren</button>
                @if ( Auth::user()->id !== $user->id )
                    <a href="/user/delete/{{ $user->id }}" type="button" class="btn btn-outline-danger"><span class="fa fa-trash fa-lg"></span> Löschen</a>
                @endif
            </div>

        </form>
    </div>

</div>
@endsection
