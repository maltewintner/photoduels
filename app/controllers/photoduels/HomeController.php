<?php

use Wintner\Repository\PhotoDuels\Picture\PictureInterface;

class HomeController extends BaseController {

	protected $layout = 'photoduels.layout.one_column';
	protected $picture = null;

	public function __construct(PictureInterface $picture)
	{
		$this->picture = $picture;
	}

	public function main()
	{
		$dataPicture = $this->picture
			->getLatestPictureForEachCategory();
		$dataMostPopularWords = $this->picture
			->getMostPopularWords();
		$this->layout->content = View::make('photoduels.page.home',
			array('dataPicture' => $dataPicture,
				'dataMostPopularWords' => $dataMostPopularWords));
	}

}
