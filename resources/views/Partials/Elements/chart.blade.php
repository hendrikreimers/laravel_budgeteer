@php
    if ( empty($backgroundColor) )
        $backgroundColor = '["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(255, 159, 64, 0.2)"]';

    if ( empty($borderColor) )
        $borderColor = '["rgba(255,99,132,1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)", "rgba(255, 159, 64, 1)"]';

    if ( empty($borderWidth) )
        $borderWidth = 1;
@endphp
<div class="chart"
     @if ( !empty($type) ) data-type="{!! $type !!}" @endif
     @if ( !empty($label) ) data-label="{!! $label !!}" @endif
     @if ( !empty($backgroundColor) ) data-backgroundColor='{!! $backgroundColor !!}' @endif
     @if ( !empty($borderColor) ) data-borderColor='{!! $borderColor !!}' @endif
     @if ( !empty($borderWidth) ) data-borderWidth="{!! $borderWidth !!}" @endif
     @if ( !empty($options) ) data-options='{!! $options !!}' @endif
     @if ( !empty($data) ) data-values='{!! $data !!}' @endif
     @if ( !empty($labels) ) data-labels='{{ $labels }}' @endif>
    <canvas></canvas>
</div>
