<div class="form-group has-feedback has-feedback-left">
    <div class="g-recaptcha" data-sitekey="6Lfz4hcaAAAAALEaRW7BanfajysIlIfCNpzG8Y4l"></div>
    @if ( $errors && $errors->has('g-recaptcha-response'))
        <div class="help-block error">{!! $errors->first('g-recaptcha-response') !!}</div>
    @endif
</div>
