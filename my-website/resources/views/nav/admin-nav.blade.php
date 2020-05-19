<!-- Stored in resources/views/nav/admin-bar.blade.php -->

<link rel="stylesheet" href="{{ URL::asset('css/admin-nav.css') }}">

<div id="admin-nav_bar" class="admin-nav">

    <nav class="admin-nav">
        <ul class="admin-nav_list admin-nav_dashboard">
            <li><a href="/" aria-label="{{ __('home') }}"><img alt="{{ __('home') }}" title="{{ __('home') }}" src="{{ URL::asset('images/home.svg') }}"/></a></li>
            <li><a href="{{ route('wp-admin') }}" target="_blank">{{ env('APP_NAME', 'Website') }} dashboard</a></li>
        </ul>

        <ul class="admin-nav_list">
            <li><a href="{{ route('clear-cache') }}">Clear Cache</a></li>
            <li><a href="{{ route('clear-views') }}">Clear Views</a></li>
            @if(!empty($post->id))
                <li>
                    <a href="{{ route('wp-admin', ['any' => 'post.php?post='.$post->id.'&action=edit'] ) }}" target="_blank">
                        Edit Post
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
