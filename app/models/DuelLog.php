<?php

class DuelLog extends Eloquent
{
	protected $table = 'duel_log';

	use SoftDeletingTrait;

	protected $fillable = array
	(
		'visitor_id',
		'picture_id_won',
		'picture_id_lost',
		'rating_won',
		'rating_lost',
	);

}
