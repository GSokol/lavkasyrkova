<div class="col-md-{{ isset($col) && $col ? $col : '12' }} col-sm-12 col-xs-12 {{ isset($addClass) && $addClass ? $addClass : '' }}">
    <label class="simple-radio">
        <input type="radio" name="{{ $name }}" class="styled" value="{{ $value }}" {{ isset($checked) && $checked ? 'checked=checked' : '' }}>{!! $label !!}
    </label>
</div>