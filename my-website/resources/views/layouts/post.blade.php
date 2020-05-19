<!-- Stored in resources/views/layouts/page.blade.php -->

@extends('app')

@section('title', $post->title ?? '')

@section('content')
    <h1>{{ $post->title ?? '' }}</h1>
    {!! $post->content ?? '' !!}

    <div id="comments-section" data-post-id="{{$post->id ?? ''}}"></div>
@endsection

@push('scripts')
<script type="text/javascript">
    const CSRF = "{{ csrf_token() }}";
    const ACTION_URL = "{{env('WP_API_BASE_URL') . '/wp-json/wp/v2/comments'}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/react/comment.js') }}"></script>
@endpush
