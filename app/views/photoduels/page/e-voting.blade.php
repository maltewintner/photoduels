@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.e-voting-navigation')

@stop

@section('largebox')

@if ( empty($dataDuel) )
	<div>
		@lang('photoduels.no_picture_in_this_category')
	</div>
@else
	<div class="duel-outer">
		<h4>@lang('photoduels.which_picture')</h4>
		<div class="home-gallery row clearfix">
			<div class="col-lg-6 col-md-6 col-xs-12 duel-thumb">
				<a class="thumbnail" href="{{ route('e-voting') }}/{{
					$pictureCategory }}?first={{
					$dataDuel['id1'] }}&second={{
					$dataDuel['id2'] }}&won={{
					$dataDuel['id1'] }}">
					<img class="img-responsive"
						alt=""
						src="{{ asset('upload/large/'
							. $dataDuel['id1']
							. '_' . $dataDuel['filename1']) }}" />
				</a>
				<small>{{ $dataDuel['short_description1'] }}</small>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 duel-thumb">
				<a class="thumbnail" href="{{ route('e-voting') }}/{{
					$pictureCategory }}?first={{
					$dataDuel['id1'] }}&second={{
					$dataDuel['id2'] }}&won={{
					$dataDuel['id2'] }}">
					<img class="img-responsive"
						alt=""
						src="{{ asset('upload/large/'
							. $dataDuel['id2']
							. '_' . $dataDuel['filename2']) }}" />
				</a>
				<small>{{ $dataDuel['short_description2'] }}</small>
			</div>
		</div>
	</div>
@endif

@stop
