<ul class="nav nav-stacked nav-pills">
	<li class="{{ $pictureCategory == 'food' ? 'active' : ''; }}">
		<a href="{{ route('e-voting') }}/food">@lang('photoduels.food')</a>
	</li>
	<li class="{{ $pictureCategory == 'nature' ? 'active' : ''; }}">
		<a href="{{ route('e-voting') }}/nature">@lang('photoduels.nature')</a>
	</li>
	<li class="{{ $pictureCategory == 'animals' ? 'active' : ''; }}">
		<a href="{{ route('e-voting') }}/animals">@lang('photoduels.animals')</a>
	</li>
	<li class="{{ $pictureCategory == 'abstract' ? 'active' : ''; }}">
		<a href="{{ route('e-voting') }}/abstract">@lang('photoduels.abstract')</a>
	</li>
</ul>
