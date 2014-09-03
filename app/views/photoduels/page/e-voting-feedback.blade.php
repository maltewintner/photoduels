@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.e-voting-navigation')

@stop

@section('largebox')

@if ( empty($dataFeedback) )
	<div>
		@lang('photoduels.no_picture_in_this_category')
	</div>
@else
	<?php

	$isFirstWinner = ($dataFeedback['won']['id'] == $dataFeedback['first']);
	$dataFirst = ($isFirstWinner ? $dataFeedback['won'] : $dataFeedback['lost']);
	$dataSecond = ($isFirstWinner ? $dataFeedback['lost'] : $dataFeedback['won']);
	$param = '&category=' . $dataFeedback['pictureCategory']
		. '&first=' . $dataFeedback['first'] . '&second='
		. $dataFeedback['second'] . '&won='
		. ($isFirstWinner ? $dataFirst['id'] : $dataSecond['id']);

	?>
	<div class="duel-outer">
		<h4>@lang('photoduels.voted_like_you',
			array('percent' => $dataFeedback['percentSameVotes']))</h4>
		<div class="home-gallery row clearfix">
			<div class="col-lg-6 col-md-6 col-xs-12 duel-thumb">
				<a class="thumbnail" href="{{ route('e-voting-detail') }}?id={{
					$dataFirst['id'] . $param }}">
					<img class="{{ $isFirstWinner ? 'duel-winner' : '' }}
						img-responsive"
						alt=""
						src="{{ asset('upload/large/' . $dataFirst['id']
						. '_' . $dataFirst['filename']) }}" />
				</a>
				<small>{{ $dataFirst['short_description'] }}</small>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 duel-thumb">
				<a class="thumbnail" href="{{ route('e-voting-detail') }}?id={{
					$dataSecond['id'] . $param }}">
					<img class="{{ $isFirstWinner ? '' : 'duel-winner' }}
						img-responsive"
						alt=""
						src="{{ asset('upload/large/' . $dataSecond['id']
						. '_' . $dataSecond['filename']) }}" />
				</a>
				<small>{{ $dataSecond['short_description'] }}</small>
			</div>
		</div>
		<a href="{{ route('e-voting-detail') }}?id={{
			($isFirstWinner ? $dataFirst['id'] : $dataSecond['id'])
				. $param }}"
			class="btn btn-new-picture">
			<i class="fam-information"></i>
			@lang('photoduels.view_details')
		</a>
		<a href="{{ route('e-voting') . '/'
			. $dataFeedback['pictureCategory'] }}"
			class="btn btn-new-picture">
			<i class="fam-arrow-right"></i>
			@lang('photoduels.next_duel')
		</a>
	</div>
@endif

@stop
