@extends('Layouts.default')

@section('content')
    <div class="row">

        @include('Partials.Header.default', [
            'header' => 'Belege'
        ])

        @if ( Auth::user()->can('create', App\Receipt::class) )
        <div class="col-8 my-2 text-right">
            <a href="/receipt/newReceipt" type="button" class="btn btn-outline-primary">Neuer Beleg</a>
        </div>
        @endif

        @component('Partials/Form/formStatus') @endcomponent

        @component('Partials/Receipts/receiptTable', ['receipts' => $receipts, 'startDate' => $startDate, 'endDate' => $endDate]) @endcomponent
    </div>
@endsection
