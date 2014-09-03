@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.account-navigation')

@stop

@section('largebox')

@include('photoduels.part.warnings')
{{ Form::open(array('url'=>'/your-account/uploads/add',
	'files' => true)) }}
	<div class="form-group">
		 <label for="picture">@lang('photoduels.picture')</label>
		 (@lang('photoduels.allowed_picture_formats'))
		 {{ Form::file('picture') }}
	</div>
	<div class="form-group">
		 <label for="picture_category">@lang('photoduels.picture_category')</label>
		 {{ Form::select('picture_category', $arrPictureCategory,
		 	( isset($validator) ?
		 		$validator->getValue('picture_category_id') : null ),
		 		array('class' => 'form-control')
		 	)
		 }}
	</div>

	<div class="form-group">
		 <label for="title">@lang('photoduels.title')</label>
		 {{ Form::text('title',
			( isset($validator) ? $validator->getValue('title') : null ),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label for="short_description">@lang('photoduels.short_description')</label>
		{{ Form::textarea('short_description',
			( isset($validator) ?
				$validator->getValue('short_description') : null ),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<div class="form-group">
		<label for="description">@lang('photoduels.description')</label>
		{{ Form::textarea('description',
			( isset($validator) ?
				$validator->getValue('description') : null ),
			array('class'=>'form-control',
			'placeholder'=>'')) }}
	</div>
	<button type="submit" class="btn btn-default">@lang('photoduels.submit')</button>
{{ Form::close() }}

@stop
