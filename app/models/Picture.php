<?php

class Picture extends Eloquent
{
	protected $table = 'picture';

	use SoftDeletingTrait;

	protected $fillable = array
	(
		'user_id',
		'picture_category_id',
	  	'title',
		'short_description',
		'description',
		'filename',
	);

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function pictureCategory()
	{
		return $this->belongsTo('PictureCategory');
	}
}
