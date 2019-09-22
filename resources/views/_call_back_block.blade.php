@if ($k == 2)
    <div class="tiles-container">
        <div class="container">
            <h1 class="text-center">{{ $head }}</h1>
            <a href="#feedback_modal" data-toggle="modal">@include('_button_block',['type' => 'submit', 'text' => $buttonText, 'icon' => 'icon-mail5'])</a>
        </div>
    </div>
@endif