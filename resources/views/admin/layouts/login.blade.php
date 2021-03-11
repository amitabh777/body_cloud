<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="hold-transition login-page">   

    @yield('content')

    @include('admin.partials.footer-scripts')

    <!-- other js script -->
    @yield('script')
   
</body>

</html>