<?php

use Wintner\Repository\PhotoDuels\Search\IndexerLaravel;
use Wintner\Repository\PhotoDuels\Search\SearcherEloquent;

class SearcherEloquentTest extends TestCase
{
	private $searcherEloquent = null;

	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate:refresh');
		Artisan::call('db:seed');
		$this->searcherEloquent = App::make(
			'Wintner\Repository\PhotoDuels\Search\SearcherInterface');
	}

	public function testSearch()
	{
		$data = $this->searcherEloquent->search('test');
		$this->assertTrue( is_array($data) );
	}
}
