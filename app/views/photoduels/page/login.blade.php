@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.login-navigation')

@stop

@section('largebox')

@include('photoduels.part.warnings')
{{ Form::open(array('url'=>'/login')) }}
	<div class="form-group">
		<label>Email</label>
		{{ Form::text('email', null, array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label>Password</label>
		{{ Form::password('password', array('class' => 'form-control',
			'placeholder' => '')) }}
	</div>
	{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
{{ Form::close() }}
<br/>
<a href="{{ route('register') }}"
	class="btn btn-new-picture">
	<i class="fam-information"></i>
	@lang('photoduels.not_registered_yet')
</a>
<a href="{{ route('forgot_password') }}"
	class="btn btn-new-picture">
	<i class="fam-information"></i>
	@lang('photoduels.forgot_password')
</a>

@stop
