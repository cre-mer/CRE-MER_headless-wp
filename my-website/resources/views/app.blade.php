<!-- Stored in resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} - @yield('title')</title>

        {{-- Scripts --}}
        @stack('styles')
    </head>
    <body>

        <div class="container">
            @yield('content')
        </div>

        <!-- Admin Bar -->
        @php
            // TODO: Add @wpauth
        @endphp
        @include('nav.admin-nav', ['post' => (array) $post])

        <!-- Scripts -->
        @stack('scripts')
    </body>
</html>
