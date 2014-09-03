<?php

use Wintner\Repository\PhotoDuels\Duel\DuelInterface;

class EVotingController extends BaseController {

	protected $layout = 'photoduels.layout.two_columns';
	protected $duel = null;

	public function __construct(DuelInterface $duel)
	{
		$this->duel = $duel;
	}

	public function main($pictureCategory = 'food')
	{
		$input = Input::all();
		$arrAlreadyVotedDuels = Session::get('arrAlreadyVotedDuels',
			array());
		if ( isset($input['first']) && isset($input['second'])
			&& isset($input['won']) )
		{
			$visitorId = Session::get('visitorId');
			if ($visitorId == null)
			{
				$visitorId = $this->duel->addVisitor(
					Request::server('HTTP_USER_AGENT'),
					Request::server('REMOTE_ADDR'));
				Session::set('visitorId', $visitorId);
			}
			$dataFeedback = $this->duel->saveVote($visitorId,
				$pictureCategory, $input['won'],
				($input['won'] == $input['first']
					? $input['second'] : $input['first']),
				$arrAlreadyVotedDuels);
			$dataFeedback['first'] = $input['first'];
			$dataFeedback['second'] = $input['second'];
			$dataFeedback['pictureCategory'] = $pictureCategory;
			$arrAlreadyVotedDuels[] = $input['first'] . 'v'
				. $input['second'];
			$arrAlreadyVotedDuels[] = $input['second'] . 'v'
				. $input['first'];
			$arrAlreadyVotedDuels = array_unique($arrAlreadyVotedDuels);
			Session::set('arrAlreadyVotedDuels', $arrAlreadyVotedDuels);
			$this->layout->content = View::make('photoduels.page.e-voting-feedback',
				array('dataFeedback' => $dataFeedback,
					'pictureCategory' => $pictureCategory));
		} else
		{
			$pictureIdPicked = Input::get('picked');
			$dataDuel = $this->duel->getDuel($pictureCategory,
				$arrAlreadyVotedDuels, $pictureIdPicked);
			if ( empty($dataDuel) && !empty($pictureIdPicked) )
			{
				return Redirect::route('detail', array('id' => $pictureIdPicked));
			} else
			{
				$this->layout->content = View::make('photoduels.page.e-voting',
					array('dataDuel' => $dataDuel,
						'pictureCategory' => $pictureCategory));
			}
		}
	}
}
