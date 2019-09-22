<div class="frame-image {{ isset($addClass) && $addClass ? $addClass : '' }}">
    <a class="img-preview" href="{{ isset($full) && $full ? $full : $preview }}"><img src="{{ $preview }}" /></a>
    @if (isset($description))
        <p>{!! $description !!}</p>
    @endif
</div>