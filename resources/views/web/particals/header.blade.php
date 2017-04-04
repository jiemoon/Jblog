<header>
    <a href="/" class="logo-link">
        <img src="/favicon.png">
    </a>
    <ul class="nav nav-list">
        <li class="nav-list-item">
            <a href="{{ config('blog.blog') }}" target="_self" class="nav-list-link {{ (Request::is('posts') || Request::is('/') ? ' active' : '') }}">BLOG</a>
        </li>
        <li class="nav-list-item">
            <a href="/archives/" target="_self" class="nav-list-link {{ (Request::is('archives') ? ' active' : '') }}">ARCHIVE</a>
        </li>
        <li class="nav-list-item">
            <a href="{{ config('blog.github') }}" target="_blank" class="nav-list-link">GITHUB</a>
        </li>
        <li class="nav-list-item">
            <a href="/rss" target="_self" class="nav-list-link">RSS</a>
        </li>
    </ul>
</header>
