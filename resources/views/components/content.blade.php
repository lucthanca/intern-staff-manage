@guest
    @if(Route::has('register'))
        <!-- Page content -->
        @yield('content')
    @endif
    @else
        @if(auth()->user()->logged_flag!=0)
            @include('components.top_nav')
            <!-- Page content -->
        @endif
            
        @yield('content')
        
@endguest