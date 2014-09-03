<?php

class PictureCategory extends Eloquent
{
	protected $table = 'picture_category';

	use SoftDeletingTrait;

	protected $fillable = array
	(
		'ident',
	);
}
