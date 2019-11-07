<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._header_auth_block')
</head>

<body class="login-container">
@include('layouts._message_modal_block')

<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <img id="logo" src="{{ asset('images/logo.svg') }}" />
                @yield('content')
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->

<script>$('.styled').uniform();</script>

</body>
</html>