<!-- Stored in resources/views/layouts/page.blade.php -->

@extends('app')

@section('title', $post['title']['rendered'])

@section('content')
    <h1>{{ $post['title']['rendered'] }}</h1>
    {!! $post['content']['rendered'] !!}
@endsection
