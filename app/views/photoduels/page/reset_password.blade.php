@extends('photoduels.layout.two_columns')

@section('largebox')

@include('photoduels.part.success_messages')

@include('photoduels.part.warnings')

@if ( empty($arrSuccessMsg) )
	{{ Form::open(array('url' => '/reset_password')) }}
		{{ Form::hidden('token', $token) }}
		<div class="form-group">
			<label>@lang('photoduels.email')</label>
			{{ Form::text('email', isset($email) ? $email : null,
				array('class'=>'form-control', 'placeholder' => '')) }}
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
@endif

@stop
