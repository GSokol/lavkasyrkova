@foreach($categories as $category)
    @if (count($category->products))
        <div class="category col-md-3 col-sm-4 col-xs-12" data-id="{{ $category->id }}" data-type="{{ $type }}">
            <div class="image"><img src="{{ asset($category->image) }}" /></div>
            <h3>{{ $category->name }}</h3>
        </div>
    @endif
@endforeach