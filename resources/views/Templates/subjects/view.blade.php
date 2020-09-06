@extends('Layouts.default')

@section('content')
    <div class="row">
        @include('Partials.Header.default', [
            'header' => 'Kategorien',
            'subHeader' => $subject->name
        ])

        @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

        @component('Partials/Form/formStatus') @endcomponent

        @if ( Auth::user()->can('update', $subject) )
        <div class="col-8 my-2">
            <div class="text-right">
                <button class="btn btn-outline-secondary mb-2" type="button" data-toggle="collapse" data-target="#collapse-form" aria-expanded="false" aria-controls="collapse-form">
                    Erweitert
                </button>
            </div>
            <div class="collapse" id="collapse-form">
                <form method="post" action="/subject/update/{{ $subject->id }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ $subject->name }}" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Aktualisieren</button>
                        @if ( !$subject->is_global )
                        <a href="/subject/delete/{{ $subject->id }}" type="button" class="btn btn-outline-danger"><span class="fa fa-trash fa-lg"></span> Löschen</a>
                        @endif
                    </div>

                </form>
            </div>
        </div>
        @endif

    </div>

    @component('Partials/Receipts/receiptTable', ['receipts' => $receipts, 'startDate' => $startDate, 'endDate' => $endDate]) @endcomponent
@endsection
