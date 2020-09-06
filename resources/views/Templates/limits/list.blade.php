@extends('Layouts.default')

@section('content')
    <div class="row">

        @include('Partials.Header.default', [
            'header' => 'Budgets'
        ])

        @if ( Auth::user()->can('create', App\Limit::class) )
        <div class="col-8 my-2 text-right">
            <a href="/limit/newLimit" type="button" class="btn btn-outline-primary">Neues Budget</a>
        </div>
        @endif

        @component('Partials/Form/formStatus') @endcomponent

        <div class="col-12 my-2">
            <!--<a class="btn-sm mb-2 collapsed" type="button" data-toggle="collapse" href="#collapse-form" role="button" aria-expanded="false" aria-controls="collapse-form">
                Erweitert
            </a>
            <div class="collapse mt-2" id="collapse-form">-->
            <form method="get">
                @csrf

                <div class="row">
                    <div class="col-2">
                        <input type="text" name="startDate" value="{{ $startDate }}" class="datepicker form-control" placeholder="Startdatum">
                    </div>
                    <div class="col-2">
                        <input type="text" name="endDate" value="{{ $endDate }}" class="datepicker form-control" placeholder="Enddatum">
                    </div>
                    <div class="col-2">
                        <input type="submit" value="Filtern" class="btn btn-outline-dark" />
                    </div>
                </div>
            </form>
            <!--</div>-->
        </div>

        @php
            $limits = $limits->paginate(10);
        @endphp

        <div class="col-12 my-2">
            @if ( $limits->count() > 0 )
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Ausgaben</th>
                        <th scope="col">Limit</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($limits as $limit)
                        <tr>
                            <td>{{ $limit->name }} ({{ $limit->receipts()->count() }})</td>
                            <td>{{ money_format('%.2n', $limit->limit) }}</td>
                            <td>{{ money_format('%.2n', $limit->receipts()->sum('debit')) }}</td>
                            <td>
                                @component('Partials/Elements/progressBar', [
                                    'currentSum' => $limit->receipts()->sum('debit'),
                                    'maxSum' => $limit->limit
                                ]) @endcomponent
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                                    <a href="/limit/view/{{ $limit->id }}" type="button" class="btn btn-primary"><span class="fa fa-edit fa-lg"></span></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $limits->links() }}
            </div>
            @else
                <p>Keine Einträge vorhanden</p>
            @endif
        </div>
    </div>
@endsection
