@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.account-navigation')

@stop

@section('largebox')

@include('photoduels.part.success_messages')

@include('photoduels.part.warnings')

{{ Form::open(array('url'=>'/your-account/profile')) }}
	<div class="form-group">
		<label for="username">Username</label>
		<div class="form-control-static">{{ $dataUser['username'] }}</div>
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		{{ Form::text('email',
			( isset($validator) ? $validator->getValue('email') : $dataUser['email']),
			array('class'=>'form-control', 'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label for="password">New password</label>
		{{ Form::password('password', array('class' => 'form-control',
			'placeholder' => '')) }}
	</div>
	<div class="form-group">
		<label for="password_confirmation">Confirm new password</label>
		{{ Form::password('password_confirmation',
			array('class' => 'form-control', 'placeholder' => '')) }}
	</div>
	{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
{{ Form::close() }}

@stop
