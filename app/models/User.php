<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{
	use UserTrait, RemindableTrait, SoftDeletingTrait;

	protected $table = 'user';

	protected $fillable = array('email', 'username', 'password');

	protected $hidden = array('password');

}
