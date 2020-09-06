@component('Partials.Elements.card', ['title' => '<b>Rest-Budget</b> (in %, akt. Monat)'])
    @php
        $labels = [];
        $data = [];

        if ( sizeof($summary->accounts) > 0 ) {
            foreach($summary->limits as $limit) {
                $labels[] = $limit->name;
                $data[]   = 100 - intval($limit->progress);
            }

            $labels = json_encode(array_merge($labels, ['']));
            $data = json_encode(array_merge($data, [100]));
        }

    @endphp
    @include('Partials.Elements.chart', [
        'type'            => 'horizontalBar',
        'label'           => ' ',
        'data'            => $data,
        'labels'          => $labels
    ])
@endcomponent
