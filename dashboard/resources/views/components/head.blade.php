<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf" content="{{ csrf_token() }}">
<title>{{ Settings::getSeoTags()['title'] ? Settings::getSeoTags()['title'] : '' }}. Админка</title>

<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<link href="{{ mix('style/dashboard.css') }}" rel="stylesheet" type="text/css">
@yield('style')

<script type="text/javascript" src="{{ asset('js/plugins/loaders/pace.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/switchery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-switch.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-toggle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/inputs/typeahead/handlebars.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/pickers/daterangepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/pickers/anytime.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.time.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/legacy.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/picker_date.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/selects/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/media/fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/datatables_basic.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/gallery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/main.controls.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/input-value.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin.js?v=4') }}"></script>

@yield('script')
