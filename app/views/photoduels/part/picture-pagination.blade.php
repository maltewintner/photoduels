{{ $pictures->links() }}

@if ( $pictures->getTotal() > 0 )
	<div class="pagination-info pull-right">
		@lang('photoduels.showing_from_to_entries',
			array
			(
				'from' => $pictures->getFrom(),
				'to' => $pictures->getTo(),
				'of' => $pictures->getTotal())
			)
	</div>
@endif