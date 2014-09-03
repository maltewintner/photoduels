<?php

use Wintner\Repository\PhotoDuels\Picture\PictureInterface;
use Wintner\Repository\PhotoDuels\User\UserInterface;
use Wintner\Repository\PhotoDuels\Duel\DuelInterface;
use Wintner\Exception\ValidatorException;

class MostPopularController extends BaseController {

	const NUMBER_PICTURES_PER_PAGE = 5;

	protected $layout = 'photoduels.layout.two_columns';
	protected $picture = null;

	public function __construct(PictureInterface $picture)
	{
		$this->picture = $picture;
	}

	public function main($pictureCategory = 'food')
	{
		$page = Input::get('page', 1);
		$dataPictures = $this->picture->getMostPopularPictures(
			$pictureCategory, $page, self::NUMBER_PICTURES_PER_PAGE);
		$pictures = Paginator::make($dataPictures['items'],
			$dataPictures['total'], self::NUMBER_PICTURES_PER_PAGE);
		$this->layout->content = View::make('photoduels.page.most-popular',
			array('pictures' => $pictures,
				'pictureCategory' => $pictureCategory));
	}

}