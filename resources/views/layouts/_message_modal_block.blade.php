@include('layouts._modal_block', ['id' => 'message', 'message' => (Session::has('message') ? Session::get('message') : '')])
@if (Session::has('message'))
    <?php Session::forget('message'); ?>
@endif
