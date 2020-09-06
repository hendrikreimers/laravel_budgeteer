@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', [
        'header' => 'Benutzer',
        'subHeader' => 'Neuer Benutzer'
    ])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/user/create">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="text" name="email" id="email" placeholder="E-Mail Adresse" class="form-control" /><br>
                <input type="text" name="email_confirmation" placeholder="E-Mail wiederholen" class="form-control" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Passwort" class="form-control" /><br>
                <input type="password" name="password_confirmation" placeholder="Passwort wiederholen" class="form-control" />
            </div>
            <div class="form-group">
                <label for="role">Gruppe</label>
                <select name="role" class="form-control">
                    @foreach ( $roles as $role )
                        <option value="{{ $role->id }}" {{ ($role->name == strtolower('user')) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Aktualisieren</button>
            </div>

        </form>
    </div>

</div>
@endsection
