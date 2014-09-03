
@if ( isset($arrSuccessMsg) )
	@foreach ($arrSuccessMsg as $ident)
		<p class="alert alert-success">
			@lang('photoduels.' . $ident)
		</p>
	@endforeach
@endif