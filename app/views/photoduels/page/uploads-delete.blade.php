@extends('photoduels.layout.two_columns')

@section('smallbox')

<img class="img-responsive center-block" alt=""
	src="{{ asset('upload/large/' . $dataPicture['id']
		. '_' . $dataPicture['filename']) }}" />

@stop

@section('largebox')

@lang('photoduels.ask_delete_picture')
<br/><br/>
{{ Form::open(array('url'=>'/your-account/uploads/delete?id='
	. $dataPicture['id'] )) }}
	<button name="yes" type="submit" class="btn btn-default">
		@lang('photoduels.yes')
	</button>
	&nbsp;&nbsp;
	<button name="no" type="submit" class="btn btn-default">
		@lang('photoduels.no')
	</button>
{{ Form::close() }}
<h3>{{ $dataPicture['title'] }}</h3>
<p><i>{{ $dataPicture['short_description'] }}</i></p>
<p>{{ $dataPicture['description'] }}</p>

@stop

