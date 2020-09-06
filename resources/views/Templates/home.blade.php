@extends('Layouts.default')

@section('content')

    <div class="row no-gutters justify-content-center px-2">
        <div class="card col-12">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                Hallo {{ Auth::user()->name }},<br>
                willkommen im Budgeteer.
            </div>
        </div>
    </div>

    <div class="row no-gutters justify-content-center">
        @include('Partials.Charts.AccountsLast')
        @include('Partials.Charts.BudgetsCurrent')
    </div>
    <!--<div class="row no-gutter justify-content-center">
        include('Partials.Charts.SubjectsLast')
    </div>-->

@endsection
