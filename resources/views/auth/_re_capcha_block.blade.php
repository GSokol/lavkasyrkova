<div class="form-group has-feedback has-feedback-left">
    <div class="g-recaptcha" data-sitekey="6LecN00UAAAAAEgF4L3wyReBOSvDXZgLNeZAD8OR"></div>
    @if ( $errors && $errors->has('g-recaptcha-response'))
        <div class="help-block error">{!! $errors->first('g-recaptcha-response') !!}</div>
    @endif
</div>