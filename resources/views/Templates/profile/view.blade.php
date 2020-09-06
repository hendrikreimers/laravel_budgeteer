@extends('Layouts.default')

@section('content')
    <div class="row">
        @include('Partials.Header.default', [
            'header' => 'Benutzerprofil'
        ])

        @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

        @component('Partials/Form/formStatus') @endcomponent

        <div class="col-6 my-2">
            <form method="post" action="/profile/update">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" readonly value="{{ $user->name }}" class="form-control-plaintext">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="text" name="name" id="email" readonly value="{{ $user->email }}" class="form-control-plaintext">
                </div>
                <div class="form-group">
                    <label for="group">Gruppe</label>
                    <input type="text" name="role" id="group" readonly value="{{ $user->roles()->first()->name }}" class="form-control-plaintext">
                </div>
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Neues Passwort" class="form-control" /><br>
                        <input type="password" name="password_confirmation" placeholder="Password wiederholen" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Aktualisieren</button>
                </div>

            </form>
        </div>

    </div>
@endsection
