<!-- Stored in resources/views/layouts/page.blade.php -->

@extends('app')

@section('title', $post->title ?? '')

@section('content')
    <h1>
        {{ trans_choice('posts.post_count', count($posts), ['count', count($posts)]) }}
    </h1>

    <ul>

        @foreach ($posts as $post)
            <li>
                <article>
                    <h2>
                        <a href="{{ $post->slug }}">{{ $post->title ?? '' }}</a>
                    </h2>

                    <address>@lang('posts.author_name', ['name' => $post->author['name']])</address>
                </article>

            </li>
        @endforeach

    </ul>
@endsection
