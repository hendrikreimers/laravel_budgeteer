@extends('Layouts.default')

@section('content')
    <div class="row">

        @include('Partials.Header.default', ['header' => 'Kategorien'])

        @if ( Auth::user()->can('create', App\Subject::class) )
        <div class="col-8 my-2 text-right">
            <a href="/subject/newSubject" type="button" class="btn btn-outline-primary">Neue Kategorie</a>
        </div>
        @endif

        @component('Partials/Form/formStatus') @endcomponent

        <div class="col-12 my-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Summe</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->name }} ({{ $subject->receipts()->count() }})</td>
                            <td>{{ money_format('%.2n', $subject->receipts()->sum('credit') - $subject->receipts()->sum('debit')) }} EUR</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                                    <a href="/subject/view/{{ $subject->id }}" type="button" class="btn btn-primary"><span class="fa fa-eye fa-lg"></span></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $subjects->links() }}
            </div>
        </div>
    </div>
@endsection
