@extends('Layouts.default')

@section('content')
<div class="row">

    @include('Partials.Header.default', [
        'header' => 'Nutzergruppen'
    ])

    <div class="col-8 my-2 text-right">
        <a href="/role/newRole" type="button" class="btn btn-outline-primary">Neue Gruppe</a>
    </div>

    @component('Partials/Form/formStatus') @endcomponent

    <div class="col-12 my-2">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <th scope="row">{{ $role->id }}</th>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="">
                                <a href="/role/view/{{ $role->id }}" type="button" class="btn btn-primary"><span class="fa fa-eye fa-lg"></span></a>
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
