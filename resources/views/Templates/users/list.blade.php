@extends('Layouts.default')

@section('content')
<div class="row">

    @include('Partials.Header.default', [
        'header' => 'Benutzer',
        'subHeader' => 'Benutzerliste'
    ])

    <div class="col-8 my-2 text-right">
        <a href="/user/newUser" type="button" class="btn btn-outline-primary">Neuer Benutzer</a>
    </div>

    @component('Partials/Form/formStatus') @endcomponent

    <div class="col-12 my-2">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Role</th>
                        <th scope="col">Disabled</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="{{ ( !$user->disabled ) ? '' : 'table-danger' }}">
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles()->first()->name }}</td>
                        <td>{{ ( $user->disabled ) ? 'Y' : 'N' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="/user/view/{{ $user->id }}" type="button" class="btn btn-primary"><span class="fa fa-eye fa-lg"></span></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
