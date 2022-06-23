<?php ob_start(); ?>
<div class="modal-body"></div>
<div class="modal-footer">
    @include('_button_block', ['type' => 'button', 'text' => 'Ok', 'addAttr' => ['data-dismiss' => 'modal']])
</div>

<?php $content = ob_get_clean(); ?>
@include('layouts._modal_block', ['id' => 'product-modal', 'title' => 'Купить продукт', 'content' => $content])
