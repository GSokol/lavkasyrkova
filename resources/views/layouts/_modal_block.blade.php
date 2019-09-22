<div id="{{ $id }}" class="modal fade {{ isset($addClass) && $addClass ? $addClass : '' }}">
    <div class="modal-dialog">
        @include('layouts._modal_content_block')
    </div>
</div>