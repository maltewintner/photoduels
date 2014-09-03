@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.login-navigation')

@stop

@section('largebox')

@include('photoduels.part.warnings')

{{ Form::open(array('url' => '/register')) }}
	<div class="form-group">
		<label>@lang('photoduels.email')</label>
		{{ Form::text('email',
			(isset($validator) ? $validator->getValue('email') : null),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label>@lang('photoduels.username')</label>
		{{ Form::text('username',
			(isset($validator) ? $validator->getValue('username') : null),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label>@lang('photoduels.password')</label>
		{{ Form::password('password', array('class' => 'form-control',
			'placeholder' => '')) }}
	</div>
	<div class="form-group">
		<label>@lang('photoduels.confirm_password')</label>
		{{ Form::password('password_confirmation',
			array('class' => 'form-control', 'placeholder' => '')) }}
	</div>
	{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
{{ Form::close() }}

@stop
