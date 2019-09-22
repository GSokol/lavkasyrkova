<?php $totalCost = 0; ?>
@foreach($order->orderToProducts as $item)
    <?php $totalCost += Helper::orderItemCost($item); ?>
@endforeach
{{ $totalCost.'р.' }}