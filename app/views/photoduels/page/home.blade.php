@extends('photoduels.layout.one_column')

@section('content')

<div class="home-gallery row clearfix">
	@foreach ($dataPicture as $record)
		<div class="col-lg-3 col-md-4 col-xs-6 thumb">
			<a class="thumbnail" href="{{ route('e-voting') }}/{{
				$record['pictureCategory'] }}?picked={{
				$record['id'] }}">
				<img class="img-responsive" alt=""
					src="{{ asset('upload/small/' . $record['id'] . '_'
						. $record['filename']) }}" />
			</a>
		</div>
	@endforeach
</div>

<div class="home-explanation row clearfix">
	<div class="col-md-8 column">
		<h3>@lang('photoduels.project_title')</h3>
		<p>@lang('photoduels.home_description')</p>
		<p>@lang('photoduels.home_description_additional')</p>
	</div>
	<div class="col-md-4 column">
		@include('photoduels.part.tagcloud')
	</div>
</div>

@stop
