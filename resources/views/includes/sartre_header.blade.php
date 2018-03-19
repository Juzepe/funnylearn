<!-- Header -->
<header class="header header-fixed header-fixed-on-mobile header-transparent" data-bkg-threshold="100" data-compact-threshold="100">
    <div class="header-inner">
        <div class="row nav-bar">
            <div class="column width-12 nav-bar-inner">
                <nav class="navigation nav-block primary-navigation nav-right">
                    <ul>
                        <li class="current">
                            <a href="{{ url('/') }}">Funny Learn</a>
                        </li>

                        @guest
	                        <li class="current">
	                            <a href="{{ route('login') }}">Login</a>
	                        </li>

	                        <li class="current">
	                            <a href="{{ route('register') }}">Register</a>
	                        </li>
                        @else
	                        <li class="current">
	                            {{ Auth::user()->name }}

	                            <ul class="sub-menu">
	                            	@ability('', 'ManageRights')
		                                <li>
		                                    <a href="{{ url('admin') }}">Dashboard</a>
		                                </li>
	                                @endability
	                                
	                                <li>
	                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	                                        {{ __('Logout') }}
	                                    </a>

	                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                        @csrf
	                                    </form>
	                                </li>
	                            </ul>
	                        </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->