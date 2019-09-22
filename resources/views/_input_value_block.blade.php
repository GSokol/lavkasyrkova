@if (isset($label) && $label)
    <p><b>{{ $label }}</b></p>
@endif
<div class="input-value-container">
    <div class="button minus"><i class="icon-minus3"></i></div>
    <div><input data-differentially="{{ $differentially }}" data-price="{{ $price }}" data-unit="{{ $unit }}" data-increment="{{ $increment }}" min="{{ $min }}" max="{{ $max }}" name="{{ $name }}" type="text" class="form-control" value="{{ count($errors) ? old($name) : $value.' '.$unit }}"></div>
    <div class="button plus"><i class="icon-plus2"></i></div>
</div>
@if ( ($errors && $errors->has($name)) || (isset($useAjax) && $useAjax))
    <div class="help-block error error-{{ $name }}">{!! $errors->first($name) !!}</div>
@endif