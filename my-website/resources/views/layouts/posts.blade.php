<!-- Stored in resources/views/layouts/page.blade.php -->

@extends('app')

@section('title', $post->title ?? null)

@section('content')
    <h1>
        {{ trans_choice('posts.post_count', count($posts), ['count', count($posts)]) }}
    </h1>

    <ul>

        {{-- Use $p instead of $post to avoid overwriting $post variable in layouts/app.blade.php --}}
        @foreach ($posts as $p)
            <li>
                <article>
                    <h2>
                        <a href="{{ $p->slug ?? '' }}">{!! $p->title ?? '' !!}</a>
                    </h2>

                    <address>@lang('posts.author_name', ['name' => $p->author['name']])</address>
                </article>

            </li>
        @endforeach

    </ul>
@endsection
