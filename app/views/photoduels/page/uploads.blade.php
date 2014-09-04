@extends('photoduels.layout.two_columns')

@section('smallbox')

@include('photoduels.part.account-navigation')

@stop

@section('largebox')

@include('photoduels.part.success_messages')

<a href="{{ route('your-account-uploads-add') }}"
	class="btn btn-new-picture">
	<i class="fam-add"></i>
	@lang('photoduels.upload_new_picture')
</a>
<ul class="list-group">
	@foreach ($pictures as $picture)
		<li>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="panel-more1">
						<a href="{{ route('your-account-detail')
							. '?id=' . $picture['id'] }}">
							<img class="img-responsive" alt=""
								src="{{asset('upload/small/'
									. $picture['id'] . '_'
									. $picture['filename'] )
								}}" />
						</a>
					</div>
					<div class="panel-info">
						<h4>{{ $picture['title'] }}</h4>
						<p>
							{{ $picture['short_description'] }}
						</p>
						<p>
							<a href="{{ route('your-account-uploads-edit')
								. '?id=' . $picture['id'] }}"
								class="btn">
								<i class="fam-pencil"></i>
								@lang('photoduels.edit')
							</a>
							<a href="{{ route('your-account-uploads-delete')
								. '?id=' . $picture['id'] }}"
								class="btn">
								<i class="fam-delete"></i>
								@lang('photoduels.delete')
							</a>
							<a href="{{ route('your-account-detail')
								. '?id=' . $picture['id'] }}"
								class="btn">
								<i class="fam-chart-bar"></i>
								@lang('photoduels.statistics')
							</a>
						</p>
					</div>
				</div>
			</div>
		</li>
	@endforeach
</ul>
@include('photoduels.part.picture-pagination')

@stop
