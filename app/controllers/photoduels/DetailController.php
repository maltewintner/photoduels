<?php

use Wintner\Repository\PhotoDuels\Picture\PictureInterface;
use Wintner\Repository\PhotoDuels\Duel\DuelInterface;

class DetailController extends BaseController {

	protected $layout = 'photoduels.layout.one_column';
	protected $picture = null;
	protected $duel = null;

	public function __construct(PictureInterface $picture,
		DuelInterface $duel)
	{
		$this->picture = $picture;
		$this->duel = $duel;
	}

	public function picture()
	{
		$dataPicture = $this->picture->getPicture(Input::get('id'));
		$this->layout->content =
			View::make('photoduels.page.detail',
			array('dataPicture' => $dataPicture));
	}

	public function accountPicture()
	{
		$dataPicture = $this->picture->getAccountPicture(
			Auth::user()->id, Input::get('id'));
		$dataDuelLog = $this->duel->getDuelLog(Input::get('id'));
		$this->layout->content =
			View::make('photoduels.page.uploads-detail',
			array('dataPicture' => $dataPicture,
				'dataDuelLog' => $dataDuelLog));
	}

	public function eVotingPicture()
	{
		$dataPicture = $this->duel->getPictureById(Input::get('id'));
		$dataPicture['first'] = Input::get('first');
		$dataPicture['second'] = Input::get('second');
		$dataPicture['won'] = Input::get('won');
		$this->layout->content = View::make(
			'photoduels.page.e-voting-detail',
			array('dataPicture' => $dataPicture));
	}

}
