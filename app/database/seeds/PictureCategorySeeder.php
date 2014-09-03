<?php

class PictureCategorySeeder extends Seeder {

	public function run()
	{
		DB::table('picture_category')->truncate();

		PictureCategory::create(array(
			'ident' => 'food',
		));
		PictureCategory::create(array(
			'ident' => 'nature',
		));
		PictureCategory::create(array(
			'ident' => 'animals',
		));
		PictureCategory::create(array(
			'ident' => 'abstract',
		));
    }

}
