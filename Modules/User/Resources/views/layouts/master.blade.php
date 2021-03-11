<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module User</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/user.css') }}"> --}}

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/user.js') }}"></script> --}}
    </body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
   @include('backend.seller.partials.head')
</head>

<body>
   @if (session('success_alert'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{session('success_alert')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
      </button>
   </div>
   @endif
   @if (session('error_alert'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{session('error_alert')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
   @include('backend.seller.partials.nav')
   <!-- @include('user::backend.partials.header') -->
   @yield('content')
   @include('backend.seller.partials.footer')
   @include('backend.seller.partials.footer-scripts')

   <!-- other js script -->
   @yield('script')
</body>

</html>
