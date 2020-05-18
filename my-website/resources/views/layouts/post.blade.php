<!-- Stored in resources/views/layouts/page.blade.php -->

@extends('app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    {!! $post->content !!}

    <div id="comments-section"></div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
@endpush
