<?php

class InvertedIndex extends Eloquent
{
	protected $table = 'inverted_index';

	use SoftDeletingTrait;

	protected $fillable = array
	(
		'word_id', 'picture_id'
	);
}
