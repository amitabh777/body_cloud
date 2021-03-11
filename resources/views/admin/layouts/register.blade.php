<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="hold-transition register-page">   

    @yield('content')

    @include('admin.partials.footer-scripts')

    <!-- other js script -->
    @yield('script')
   
</body>

</html>

