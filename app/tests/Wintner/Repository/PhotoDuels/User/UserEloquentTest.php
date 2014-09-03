<?php

use Wintner\Repository\PhotoDuels\User\UserEloquent;
use Wintner\Repository\PhotoDuels\User\UserLaravelValidator;

class UserEloquentTest extends TestCase
{
	private $userEloquent = null;

	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate:refresh');
		Artisan::call('db:seed');
		$this->userEloquent = App::make(
			'Wintner\Repository\PhotoDuels\User\UserInterface');
	}

	/**
	 *
	 * @expectedException Wintner\Exception\ValidatorException
	 */
	public function testLoginThatFails()
	{
		$this->userEloquent->login('test@example.com', 'abcdefg');
	}

	public function testRegister()
	{
		$userId = $this->userEloquent->register('test@example.com',
			'Test', 'abcdefg', 'abcdefg');
		$this->assertTrue( is_numeric($userId) );
	}

	/**
	 *
	 * @expectedException Wintner\Exception\ValidatorException
	 */
	public function testRegisterWithInvalidEmail()
	{
		$userId = $this->userEloquent->register('abc',
			'Test', 'abcdefg', 'abcdefg');
	}

}
