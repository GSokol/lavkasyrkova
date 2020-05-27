<div class="{{ isset($addClass) ? $addClass : '' }} form-group has-feedback {{ $errors && $errors->has($name) ? 'has-error' : '' }}">
    @if (isset($label) && $label)
        <label class="control-label col-md-12 text-semibold">{{ $label }}</label>
    @endif
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select name="{{ $name }}" class="form-control">
            @if (isset($firstEmpty) && $firstEmpty)
                <option value="" {{ !$selected ? 'selected' : '' }}>нет</option>
            @endif

            @if (is_array($values))
                @foreach ($values as $value => $options)
                    <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>{{ $options }}</option>
                @endforeach
            @else
                @foreach ($values as $value)
                    <option value="{{ $value->id }}" {{ $value->id == $selected ? 'selected' : '' }}>{{ $value->address ? $value->address : ($value->name ? $value->name : $value->email) }}</option>
                @endforeach
            @endif
        </select>

        @if (count($errors) && $errors->has($name))
            <div class="form-control-feedback">
                <i class="icon-cancel-circle2"></i>
            </div>
            <span class="help-block error">{{ $errors->first($name) }}</span>
        @endif
    </div>
</div>