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
			<h3>{{ $dataPicture['title'] }}</h3>
			<p><i>{{ $dataPicture['short_description'] }}</i></p>
			<p>{{ $dataPicture['description'] }}</p>
			@if ( !empty($dataDuelLog['items']) )
				<br/>
				<h4>Statistics</h4>
				<ul class="list-unstyled">
					<li>
						@lang('photoduels.rank'):
						<b>{{ $dataDuelLog['rank'] }}</b>
					</li>
					<li>
						@lang('photoduels.number_votes'):
						<b>{{ $dataDuelLog['won']
							+ $dataDuelLog['lost'] }}</b>
						(@lang('photoduels.won'):
						<b>{{ $dataDuelLog['won'] }}</b>,
						@lang('photoduels.lost'):
						<b>{{ $dataDuelLog['lost'] }}</b>)
					</li>
				</ul>
				<br/>
				<table class="table">
					<tr>
						<th>@lang('photoduels.rating')</th>
						<th>@lang('photoduels.result')</th>
						<th>@lang('photoduels.date')</th>
						<th>@lang('photoduels.opponent')</th>
					</tr>
					@foreach ($dataDuelLog['items'] as $row)
						<tr>
							<td>{{ $row['rating'] }}</td>
							<td>
								{{ ($row['won_yn'] == 1) ? 'won' : 'lost' }}
							</td>
							<td>{{ $row['date'] }}</td>
							<td>
								<a href="{{ route('detail')
									. '?id=' . $row['picture_id_opponent'] }}">
									@lang('photoduels.here')
								</a>
							</td>
						</tr>
					@endforeach
				</table>
			@endif
		</div>
	</div>
@endif

@stop
