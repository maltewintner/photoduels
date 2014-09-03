<?php

class PictureSeeder extends Seeder {

	public function run()
	{
		Session::flush();
		DB::table('picture')->truncate();
		DB::table('duel_log')->truncate();
		DB::table('inverted_index')->truncate();
		DB::table('visitor')->truncate();
		DB::table('word')->truncate();
		$indexer = App::make('Wintner\Repository\PhotoDuels\Search\IndexerInterface');
		$picture = App::make('Wintner\Repository\PhotoDuels\Picture\PictureInterface');

		$data = array();

		foreach ($data as $key => $record)
		{
			Picture::create($record);
			$indexer->index($key + 1,
				$picture->getPictureCategory($record['picture_category_id'])
				. ' ' . $record['title'] . ' ' . $record['short_description']
				. ' ' . $record['description']);
		}
    }

}
