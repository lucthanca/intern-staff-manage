@guest
@if (Route::has('register'))
<!-- Page content -->
@yield('content')
@endif
@else
@include('components.top_nav')
<!-- Page content -->
@yield('content')
@endguest