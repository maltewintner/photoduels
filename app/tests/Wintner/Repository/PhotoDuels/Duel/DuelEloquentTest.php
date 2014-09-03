<?php

use Wintner\Repository\PhotoDuels\Duel\DuelEloquent;

use Wintner\Repository\PhotoDuels\Picture\PictureEloquent;
use Wintner\Repository\PhotoDuels\Picture\PictureLaravelValidator;
use Wintner\Repository\PhotoDuels\Visitor\VisitorEloquent;
use Wintner\Repository\PhotoDuels\Visitor\VisitorLaravelValidator;

class DuelEloquentTest extends TestCase
{
	private $duelEloquent = null;

	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate:refresh');
		Artisan::call('db:seed');
		$this->duelEloquent = App::make(
			'Wintner\Repository\PhotoDuels\Duel\DuelInterface');
	}

	public function testGetDuel()
	{
		$data = $this->duelEloquent->getDuel('food');
		$this->assertTrue(isset($data['id1'])
			&& isset($data['id2']));
	}

	public function testAddVisitor()
	{
		$visitorId = $this->duelEloquent->addVisitor('test', 'localhost');
		$this->assertTrue( is_numeric($visitorId) );
	}

	public function testSaveVote()
	{
		$visitorId = $this->duelEloquent->addVisitor('test', 'localhost');
		$data = $this->duelEloquent->saveVote($visitorId, 'food', 1, 5);
		$this->assertTrue( is_array($data) );
	}
}
