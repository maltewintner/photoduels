<?php

use Wintner\Repository\PhotoDuels\Visitor\VisitorEloquent;
use Wintner\Repository\PhotoDuels\Visitor\VisitorLaravelValidator;

class VisitorEloquentTest extends TestCase
{
	private $visitorEloquent = null;

	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate:refresh');
		Artisan::call('db:seed');
		$this->visitorEloquent = App::make(
			'Wintner\Repository\PhotoDuels\Visitor\VisitorInterface');
	}

	public function testAdd()
	{
		$visitorId = $this->visitorEloquent->add('test', 'localhost');
		$this->assertTrue( is_numeric($visitorId) );
	}
}
