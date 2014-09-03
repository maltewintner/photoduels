<?php

if ( isset($validator) )
{
	$arrErrorMsg = $validator->getErrors();
}

if ( isset($arrErrorMsg) )
{
	foreach ($arrErrorMsg as $ident)
	{
		?>
		<p class="alert alert-danger">@lang('photoduels.' . $ident)</p>
		<?php
	}
}

?>