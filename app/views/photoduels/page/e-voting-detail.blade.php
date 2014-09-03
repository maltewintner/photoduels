@extends('photoduels.layout.one_column')

@section('content')

@if ( empty($dataPicture) )
	<div class="detail row clearfix">
		@lang('photoduels.no_item_found')
	</div>
@else
	<div class="detail row clearfix">
		<div class="col-md-4 column">
			<img class="img-responsive center-block" alt=""
				src="{{ asset('upload/large/' . $dataPicture['id']
					. '_' . $dataPicture['filename']) }}" />
		</div>
		<div class="col-md-8 column">
			<a href="{{ route('e-voting') . '/'
				. $dataPicture['pictureCategory'] . '?first='
				. $dataPicture['first'] . '&second='
				. $dataPicture['second'] . '&won='
				. $dataPicture['won'] }}"
				class="btn btn-new-picture">
				<i class="fam-arrow-left"></i>
				@lang('photoduels.back')
			</a>
			<a href="{{ route('e-voting') . '/'
				. $dataPicture['pictureCategory'] }}"
				class="btn btn-new-picture">
				<i class="fam-arrow-right"></i>
				@lang('photoduels.next_duel')
			</a>
			<h3>{{ $dataPicture['title'] }}</h3>
			<p><i>{{ $dataPicture['short_description'] }}</i></p>
			<p>{{ $dataPicture['description'] }}</p>
		</div>
	</div>
@endif

@stop
