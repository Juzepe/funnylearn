<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.admin_head')
        @stack('styles')
    </head>

    <body>
        @include('includes.admin_header')

        @include('includes.admin_sidebar')

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            @yield('content')
        </div>

        @stack('scripts')
        @include('includes.admin_before_body')
    </body>
</html>