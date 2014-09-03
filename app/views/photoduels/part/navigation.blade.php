<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle"
				data-toggle="collapse"
				data-target="#bs-example-navbar-collapse-1">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="{{ BladeViewHelper::checkRoute(array('home'),
					'active') }}">
					<a href="{{ route('home') }}">
						@lang('photoduels.home')
					</a>
				</li>
				<li class="{{ BladeViewHelper::checkRoute(array('e-voting',
					'e-voting-detail'), 'active') }}">
					<a href="{{ route('e-voting') }}">
						@lang('photoduels.evoting')
					</a>
				</li>
				<li class="{{ BladeViewHelper::checkRoute(array('most-popular'),
					'active') }}">
					<a href="{{ route('most-popular') }}">
						@lang('photoduels.most_popular')
					</a>
				</li>
				<li class="{{ BladeViewHelper::checkRoute(array('your-account',
					'your-account-uploads', 'your-account-uploads-add',
					'your-account-profile', 'your-account-detail',
					'login', 'register'), 'active') }}">
					<a href="{{ route('your-account') }}">
						@lang('photoduels.your_account')
					</a>
				</li>
			</ul>
			{{ Form::open(array('url' => route('search'),
				'method' => 'GET',
				'class' => 'navbar-form navbar-left' )) }}
				<div class="form-group">
					{{ Form::text('q', Input::get('q'),
						array('class' => 'form-control',
						'placeholder' => Lang::get('photoduels.search'))) }}
				</div>
				<button type="submit" class="btn btn-default">
					@lang('photoduels.submit')
				</button>
			{{ Form::close() }}
		</div>
	</div>
</nav>
