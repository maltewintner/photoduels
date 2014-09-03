
@if ( Auth::check() )
	@lang('photoduels.hello') <b>{{ Auth::user()->username }}</b>,
	<a href="{{ route('logout') }}">@lang('photoduels.logout')</a>
@else
	<a href="{{ route('login') }}">@lang('photoduels.login_small')</a>
	@lang('photoduels.or')
	<a href="{{ route('register') }}">@lang('photoduels.register_small')</a>
@endif
