@component('Partials.Elements.card', ['title' => '<b>Kontostände</b> (3 Monate)'])
    @php
        if ( sizeof($summary->accounts) > 0 ) {
            $data   = [];
            $labels = [];
            $i      = 0;

            foreach($summary->accounts as $account) {
                $labels[] = $account->name;

                foreach ( $account->sumMonths as $n => $month )
                    $data[$n][$i] = $month->sumCredit - $month->sumDebit;

                $i++;
            }

            $labels = json_encode($labels);
            $data   = json_encode($data);
        }
    @endphp
    @include('Partials.Elements.chart', [
        'type'            => 'bar',
        'label'           => ' ',
        'data'            => $data,
        'labels'          => $labels
    ])
@endcomponent
