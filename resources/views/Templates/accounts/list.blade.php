@extends('Layouts/default')

@section('content')
    <div class="row">

        @include('Partials/Header/default', ['header' => 'Konten'])

        @if ( Auth::user()->can('create', 'App\Account') )
        <div class="col-8 my-2 text-right">
            <a href="/account/newAccount" type="button" class="btn btn-outline-primary">Neues Konto</a>
        </div>
        @endif

        @component('Partials/Form/formStatus') @endcomponent

        <div class="col-12 my-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Kontostand</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->name }} ({{ $account->receipts()->count() }})</td>
                            <td>{{ money_format('%.2n', $account->receipts()->sum('credit') - $account->receipts()->sum('debit')) }} EUR</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                                    <a href="/account/view/{{ $account->id }}" type="button" class="btn btn-primary"><span class="fa fa-eye fa-lg"></span></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $accounts->links() }}
            </div>
        </div>
    </div>
@endsection
