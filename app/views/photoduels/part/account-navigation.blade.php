<ul class="nav nav-stacked nav-pills">
	<li class="{{ BladeViewHelper::checkRoute(
		array('your-account-profile'), '', 'active') }}">
		<a href="{{ route('your-account-uploads') }}">
			@lang('photoduels.your_uploads')
		</a>
	</li>
	<li class="{{ BladeViewHelper::checkRoute(
		array('your-account-profile'), 'active') }}">
		<a href="{{ route('your-account-profile') }}">
			@lang('photoduels.your_profile')
		</a>
	</li>
</ul>
