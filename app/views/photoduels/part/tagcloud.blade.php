<div class="tagcloud">
	<?php

	$data = array();
	$maxOcc = 0;
	foreach ($dataMostPopularWords as $word => $occurence)
	{
		if ($maxOcc < $occurence) $maxOcc = $occurence;
		$data[] = array('word' => $word,
			'occurence' => $occurence);
	}
	shuffle($data);

	foreach ($data as $record)
	{
		$nr = round(4 * $record['occurence']/$maxOcc);
		?>
		<a href="{{ route('search') . '?q='
			. htmlentities($record['word']) }}"
				class="tag{{ $nr }}">{{ $record['word'] }}</a>
		<?php
	}

	?>
</div>