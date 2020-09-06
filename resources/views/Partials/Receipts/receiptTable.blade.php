@php
    $receipts = $receipts->paginate(15)
@endphp

<div class="col-12">
    <h5>Belegliste</h5>
</div>

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

<div class="col-12 my-2">
    @if ( $receipts->count() > 0 )
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort' => 'name']) }}">Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort' => 'date']) }}">Datum</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort' => 'credit']) }}">Einnahmen</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort' => 'debit']) }}">Ausgaben</a></th>
                    <th>Kategorie</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $receipts as $receipt )
                    <tr>
                        <td><a href="/receipt/view/{{ $receipt->id }}">{{ $receipt->name }}</a></td>
                        <td>{{ strftime('%d.%m.%Y', $receipt->date) }}</td>
                        <td>{{ money_format('%.2n', $receipt->credit) }} €</td>
                        <td>{{ money_format('%.2n', $receipt->debit) }} €</td>
                        <td>
                            @if ( !empty($receipt->subject()) )
                                <a href="/subject/view/{{ $receipt->subject()->id }}">{{ $receipt->subject()->name }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="text-right"><b>Gesamt</b></td>
                    <td><strong>{{ money_format('%.2n', $receipts->sum('credit')) }}</strong></td>
                    <td><strong>{{ money_format('%.2n', $receipts->sum('debit')) }}</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Differenz</td>
                    @if ( ($receipts->sum('credit') - $receipts->sum('debit')) > 0 )
                        <td colspan="3" class="text-dark">
                            +{{ money_format('%.2n', $receipts->sum('credit') - $receipts->sum('debit')) }}
                        </td>
                    @else
                        <td></td>
                        <td colspan="2" class="text-danger">
                            {{ money_format('%.2n', $receipts->sum('credit') - $receipts->sum('debit')) }}
                        </td>
                    @endif

                </tr>
                </tbody>
            </table>

            {{ $receipts->links() }}
        </div>
    @else
        <p>Keine Belege vorhanden</p>
    @endif
</div>
