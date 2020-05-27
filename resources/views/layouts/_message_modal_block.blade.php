@include('layouts._modal_block',['id' => 'message', 'message' => (Session::has('message') ? Session::get('message') : '')])
<script>window.showMessage = parseInt("{{ Session::has('message') }}");</script>
@if (Session::has('message'))
    <?php Session::forget('message'); ?>
@endif