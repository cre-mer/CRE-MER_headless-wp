<!-- Stored in resources/views/nav/admin-bar.blade.php -->

<div id="admin-nav_bar" class="admin-nav">
    <nav class="admin-nav">
        <p class="admin-nav_dashboard">
            <a href="{{ route('wp-admin') }}" target="_blank">{{env('APP_NAME')}} dashboard</a>
        </p>

        <ul class="admin-nav_list">
            <li><a href="{{ route('clear-cache') }}">Clear Cache</a></li>
            <li><a href="{{ route('clear-views') }}">Clear Views</a></li>
            <li>
                <a href="{{ route('wp-admin', ['any' => 'post.php?post='.$post["id"].'&action=edit'] ) }}" target="_blank">
                    Edit Post
                </a>
            </li>
        </ul>
    </nav>
</div>
