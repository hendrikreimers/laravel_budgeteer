@component('Partials.Elements.card', ['title' => '<b>Kategorien</b> (3 Monate)'])
    @php
        if ( sizeof($summary->subjects) > 0 ) {
            $datasets = [];
            $subjectNames = [];

            foreach ( $summary->subjects as $subject ) {
                $monthNames = [];
                $data       = [];
                $subjectNames[] = $subject->name;

                foreach( $subject->sumMonths as $month ) {
                    $sum = $month->sumCredit - $month->sumDebit;

                    if ( $sum < 0 )
                        $sum = $sum * -1;

                    if ( $sum < 1000 ) {
                        $data[]       = $sum;
                        $monthNames[] = $month->name;
                    }
                }

                $datasets[] = (object)[
                    'labels' => $monthNames,
                    'data' => $data
                ];
            }

            $datasets = json_encode($datasets);
            $subjectNames = json_encode($subjectNames);
        }
    @endphp
    <div class="manualChart">
        <canvas id="subjects"></canvas>
    </div>
    <script type="text/javascript">
        var config = {
            type: 'bar',
            data: {
                labels: {!! $subjectNames !!},
                datasets: {!! $datasets !!}
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Chart.js Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('subjects').getContext('2d');
            window.subjectLine = new Chart(ctx, config);
        };
    </script>
@endcomponent
