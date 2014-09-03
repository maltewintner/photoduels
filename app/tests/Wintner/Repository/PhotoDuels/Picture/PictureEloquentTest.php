<?php

use Wintner\Repository\PhotoDuels\Picture\PictureEloquent;
use Wintner\Repository\PhotoDuels\Picture\PictureLaravelValidator;

class PictureEloquentTest extends TestCase
{
	private $pictureEloquent = null;

	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate:refresh');
		Artisan::call('db:seed');
		$this->pictureEloquent = App::make(
			'Wintner\Repository\PhotoDuels\Picture\PictureInterface');
	}

	public function testGetLatestPictureForEachCategory()
	{
		$data = $this->pictureEloquent->getLatestPictureForEachCategory();
		$this->assertTrue( is_array($data) );
	}

	public function testGetMostPopularPictures()
	{
		$data = $this->pictureEloquent->getMostPopularPictures('food');
		$this->assertTrue( is_array($data) );
	}

	public function testGetAccountPictures()
	{
		$data = $this->pictureEloquent->getAccountPictures(1);
		$this->assertTrue( is_array($data) );
	}
}
