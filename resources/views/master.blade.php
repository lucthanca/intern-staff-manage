<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>@yield('title')</title>

    @include('components.css')
</head>

<body class="@yield('body-class')">
    @guest
    
    @if (Route::has('register'))
    <div class="main-content">
        @include('components.content')
    </div>
    @endif
    @else
    @include('components.nav')

    <div class="main-content">
        @include('components.content')
    </div>
    @endguest



    @include('components.js')
</body>

</html>