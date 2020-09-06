@php
    $percentage = ($currentSum * 100) / $maxSum;
    $progress   = ceil(min(max(0, $percentage), 100));

    switch ( $progress ) {
        case ($progress >= 75):
            $progressLayout = 'danger';
            break;
        case ($progress > 50):
            $progressLayout = 'warning';
            break;
        default:
            $progressLayout = 'success';
            break;
    }
@endphp
<div class="progress">
    <div class="progress-bar bg-{{ $progressLayout }}" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
