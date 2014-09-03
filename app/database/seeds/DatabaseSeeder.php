<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		if ( App::isLocal() || App::runningUnitTests() )
		{
			$this->call('UserSeeder');
		}

		$this->call('PictureCategorySeeder');

		if ( App::isLocal() || App::runningUnitTests() )
		{
			$this->call('PictureSeeder');
		}
	}

}
