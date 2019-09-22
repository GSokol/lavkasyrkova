<div class="clearfix form-group textarea has-feedback {{ $errors && $errors->has($name) ? 'has-error' : '' }}" style="margin-bottom: 0;">
    @if (isset($label) && $label)
        <p class="description">{{ $label }}</p>
    @endif
    <textarea name="{{ $name }}">{{ count($errors->getMessageBag()) ? old($name) : (isset($value) ? $value : '') }}</textarea>

    @if ($errors && $errors->has($name) || (isset($useAjax) && $useAjax))
        <div class="help-block error error-{{ $name }}">{{ $errors->first($name) }}</div>
    @endif
    @if (!isset($simple) || !$simple)
        <script>CKEDITOR.replace('{{ $name }}');</script>
    @endif
</div>
