<?php
    if (isset($addAttr) && count($addAttr)) {
        $attrString = '';
        foreach ($addAttr as $attrName => $attrValue) {
            $attrString .= $attrName.'="'.$attrValue.'" ';
        }
    }
?>

<div class="form-group has-feedback has-feedback-left {{ isset($addClass) ? $addClass : '' }}" {!! isset($attrString) ? $attrString : '' !!}>
    @if (isset($label) && $label)
        <label class="control-label col-md-12 text-semibold">{{ $label }}</label>
    @endif
    <div>
        <input {{ isset($disabled) && $disabled ? 'disabled=disabled' : '' }} {{ !isset($icon) || !$icon ? 'style=padding-left:10px' : '' }} {{ isset($min) && $min ? 'min='.$min : '' }} {{ isset($max) && $max ? 'max='.$max : '' }} name="{{ $name }}" type="{{ $type }}" class="form-control" placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}" value="{{ isset($value) && !count($errors) ? $value : old($name) }}">
        @if (isset($icon) && $icon)
            <div class="form-control-feedback">
                <i class="{{ $icon }} text-muted"></i>
            </div>
        @endif
        @if ( (count($errors) && $errors->has($name)) || (isset($useAjax) && $useAjax))
            <div class="help-block error error-{{ $name }}">{!! $errors->first($name) !!}</div>
        @endif
    </div>
</div>