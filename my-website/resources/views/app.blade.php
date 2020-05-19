<!-- Stored in resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} - @yield('title', env('APP_NAME'))</title>
        <meta name="og:title" content="{{ $post['seo_title'] ?? '' }}">
        <meta name="description" content="{{ $post['meta_description'] ?? '' }}">

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
        @include('nav.admin-nav', ['post' => (array) ($post ?? '')])

        <!-- Scripts -->
        <script type="text/javascript">
            const CSRF = "{{ csrf_token() }}";
            const ACTION_URL = env('WP_API_BASE_URL') . "/wp-json/wp/v2/comments";
        </script>
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
