@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.login-navigation')

@stop

@section('largebox')

@include('photoduels.part.success_messages')
@include('photoduels.part.warnings')

@if ( !isset($arrSuccessMsg) )
	<p>
		@lang('photoduels.forgot_password_instruction')
	</p>
	{{ Form::open(array('url'=>'/forgot_password')) }}
		<div class="form-group">
			<label>Email</label>
			{{ Form::text('email', null, array('class' => 'form-control',
				'placeholder'=>'')) }}
		</div>
		{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
	{{ Form::close() }}
@endif

@stop
