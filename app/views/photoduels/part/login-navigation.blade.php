<ul class="nav nav-stacked nav-pills">
	<li class="{{ BladeViewHelper::checkRoute(array('register'), '', 'active') }}">
		<a href="{{ route('login') }}">@lang('photoduels.login')</a>
	</li>
	<li class="{{ BladeViewHelper::checkRoute(array('register'), 'active') }}">
		<a href="{{ route('register') }}">@lang('photoduels.register')</a>
	</li>
</ul>
