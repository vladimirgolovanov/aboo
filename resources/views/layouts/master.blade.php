<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="/css/master.css">
<title>@yield('title')</title>
@yield('meta')
</head>
<body>
<div class="topMenu">
    <div class="topMenuLogo"><a href="/">aboo</a></div>
    @if (Auth::guest())
        <div class="topMenuLogin">
            <a href="{{ route('login') }}">Login</a>
            |
            <a href="{{ route('register') }}">Register</a>
        </div>
    @else
        <div class="topMenuUsername">{{ Auth::user()->username }}</div>
        <div class="topMenuLogout">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        </div>
    @endif
</div>
<div class="header">
@yield('header')
</div>
@yield('controllers')
@yield('content')
<script src="/js/main.js"></script>
</body>
</html>