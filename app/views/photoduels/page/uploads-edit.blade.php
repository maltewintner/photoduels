@extends('photoduels.layout.two_columns')

@section('smallbox')

<img class="img-responsive center-block" alt=""
	src="{{ asset('upload/large/' . $dataPicture['id']
		. '_' . $dataPicture['filename']) }}" />

@stop

@section('largebox')

<a href="{{ route('your-account') }}"
	class="btn btn-new-picture">
	<i class="fam-arrow-left"></i>
	@lang('photoduels.back')
</a>
@include('photoduels.part.warnings')
{{ Form::open(array('url'=>'/your-account/uploads/edit'
	. '?id=' . $dataPicture['id'] )) }}
	<div class="form-group">
		 <label for="title">Title</label>
		 {{ Form::text('title',
			( isset($validator) ? $validator->getValue('title')
				: $dataPicture['title'] ),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label for="short_description">Short description</label>
		{{ Form::textarea('short_description',
			( isset($validator) ?
				$validator->getValue('short_description')
					: $dataPicture['short_description'] ),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		{{ Form::textarea('description',
			( isset($validator) ?
				$validator->getValue('description')
					: $dataPicture['description'] ),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<button type="submit" class="btn btn-default">Submit</button>
{{ Form::close() }}

@stop
