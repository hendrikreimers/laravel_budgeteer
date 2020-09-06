@extends('Layouts.default')

@section('content')
<div class="row">
    @include('Partials.Header.default', [
        'header' => 'Kategorien',
        'subHeader' => 'Neue Kategorie'
    ])

    @component('Partials/Form/formErrors', ['errors' => $errors]) @endcomponent

    <div class="col-6 my-2">
        <form method="post" action="/subject/create">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="" class="form-control">
            </div>
            @if ( Auth::user()->can('setGlobal', \App\Subject::class) )
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" id="global" name="global" value="1" class="form-check-input">
                    <label for="global" class="form-check-label">Global</label>
                </div>
            </div>
            @endif
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Erstellen</button>
            </div>

        </form>
    </div>

</div>
@endsection
