@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.most-popular-navigation')

@stop

@section('largebox')

<ul class="list-group">
	@foreach ($pictures as $picture)
		<li>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="panel-more1">
						<a href="{{ route('detail')
							. '?id=' . $picture['id'] }}">
							<img class="img-responsive" alt=""
								src="{{ asset('upload/small/'
									. $picture['id']
									. '_' . $picture['filename'])
									}}" />
						</a>
					</div>
					<div class="panel-info">
						<h4>{{ $picture['title'] }}</h4>
						<p>
							{{ $picture['short_description'] }}
						</p>
					</div>
				</div>
			</div>
		</li>
	@endforeach
</ul>
@include('photoduels.part.picture-pagination')

@stop
