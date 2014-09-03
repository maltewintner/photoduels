<?php

use Wintner\Repository\PhotoDuels\Search\SearcherInterface;

class SearchController extends BaseController {

	const NUMBER_PICTURES_PER_PAGE = 5;

	protected $layout = 'photoduels.layout.one_column';
	protected $searcher = null;

	public function __construct(SearcherInterface $searcher)
	{
		$this->searcher = $searcher;
	}

	public function main()
	{
		$page = Input::get('page', 1);
		$searchQuery = Input::get('q');
		$dataPictures = $this->searcher->search($searchQuery);
		$pictures = Paginator::make($dataPictures['items'],
			$dataPictures['total'], self::NUMBER_PICTURES_PER_PAGE);
		$this->layout->content = View::make('photoduels.page.search',
			array('pictures' => $pictures, 'searchQuery' => $searchQuery));
	}
}