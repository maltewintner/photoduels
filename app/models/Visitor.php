<?php

class Visitor extends Eloquent
{
	use SoftDeletingTrait;

	protected $table = 'visitor';

	protected $fillable = array
	(
		'user_agent',
		'remote_addr',
	);
}
