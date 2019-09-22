<?php

if ($status) {
    $label = 'info';
    $status = $trueLabel;
} else {
    $label = 'success';
    $status = $falseLabel;
}
?>

<span class="label label-{{ $label }}">{{ $status }}</span>