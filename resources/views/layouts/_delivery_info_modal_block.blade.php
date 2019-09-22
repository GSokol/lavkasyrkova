<?php ob_start(); ?>
<div class="modal-body">
    <h1 style="text-transform: none;">При сумме заказа от 10 000р. —<br> доставка по Москве бесплатно!</h1>
</div>
<!-- Футер модального окна -->
<div class="modal-footer">
    @include('_button_block', ['type' => 'button', 'text' => trans('content.close'), 'addAttr' => ['data-dismiss' => 'modal']])
</div>

@include('layouts._modal_block',['id' => 'delivery-info', 'title' => null, 'content' => ob_get_clean()])

@if (!isset($_COOKIE['delivery']) || !$_COOKIE['delivery'])
    <script>
        $(window).ready(function () {
            setTimeout(function () {
                $('#delivery-info').modal('show');
            }, 3000);
        });
    </script>
    <?php setcookie('delivery', true, time()+(60 * 10)); ?>
@endif