<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('admin.partials.nav')

        @include('admin.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('admin.partials.header')
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
        </div>
        @include('admin.partials.footer')
    </div>
    @include('admin.partials.footer-scripts')

    <!-- other js script -->
    @yield('script')


</body>

</html>