<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <h1>{{ $post->title }}</h1>
        {!! $post->content !!}

        <div id="comments-section" data-post-id="{{ $post->id }}"></div>

        <!-- Scripts -->
		@stack('scripts')
		<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>
