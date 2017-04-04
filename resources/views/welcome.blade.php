<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ config('blog.title') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="short icon" href="/favicon.png">
        <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            html,body,ul,li {margin: 0;padding: 0}
            body { background: #fff; font-family: sans-serif,"Arial","Microsoft YaHei","黑体","宋体"; color: #333; line-height: 1; text-align: center; font-size: 1em; padding-top: 1em;    padding-top: 14%;}
            h1 { margin: 0.8em 0; font-size: 2.4em; height: 1em; }
            p.info {color: #999;margin-bottom: 3em;line-height: 20px;}
            ul {list-style: none;}
            ul li {height: 50px;display: inline-block;line-height: 50px;}
            ul li a {text-decoration: none;color: #333;padding: 0 20px;}
            footer {color: #ACACAC; margin: 3em;}
        </style>
    </head>
    <body>
        <h1>Hi, I'm jiemoon.</h1>
        <p class="info">
            A full stack web developer in Xiamen, China.
        </p>
        <ul>
            <li>
                <a href="{{ config('blog.blog') }}">
                    <i class="fa fa-wordpress fa-2x"></i>
                </a>
            </li>
            <li>
                <a href="{{ config('blog.github') }}" target="_blank">
                    <i class="fa fa-github fa-2x"></i>
                </a>
            </li>
            <li>
                <a href="{{ config('blog.weibo') }}" target="_blank">
                    <i class="fa fa-weibo fa-2x"></i>
                </a>
            </li>
        </ul>
        <footer>
            jiemoon.me &copy; 2015 - 2017
        </footer>
    </body>
</html>
