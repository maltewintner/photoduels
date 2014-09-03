<?php
/**
 * Duel
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Duel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Wintner\Repository\PhotoDuels\Picture\PictureInterface;
use Wintner\Repository\PhotoDuels\Visitor\VisitorInterface;
use Wintner\Helper\EloRating;
use Wintner\Helper\InputChecker;

/**
 * Class representing a picture duel.
 */
class DuelEloquent implements DuelInterface
{
	/**
	 * @var PictureInterface Picture model
	 */
	protected $picture = null;

	/**
	 * @var VisitorInterface Visitor model
	 */
	protected $visitor = null;

	/**
	 * @var Model Duel logs
	 */
	protected $duelLog = null;

	/**
	 * Initializes the duel.
	 *
	 * @param PictureInterface $picture
	 * @param VisitorInterface $visitor
	 * @param Model $duelLog
	 */
	public function __construct(PictureInterface $picture,
		VisitorInterface $visitor, Model $duelLog)
	{
		$this->picture = $picture;
		$this->visitor = $visitor;
		$this->duelLog = $duelLog;
	}

	/**
	 * Gets next duel.
	 *
	 * @param string $pictureCategory
	 * @param array $arrAlreadyVotedDuels
	 * @param int $pictureIdPicked
	 * @return array Duel data
	 */
	public function getDuel($pictureCategory,
		array $arrAlreadyVotedDuels = array(), $pictureIdPicked = null)
	{
		$alreadyVotedDuels = '';
		foreach ($arrAlreadyVotedDuels as $duelIdent)
		{
			$alreadyVotedDuels .=
				DB::connection()->getPdo()->quote($duelIdent) . ',';
		}
		$conditionPicked = 'true';
		$arrParameter = array('pictureCategory' => $pictureCategory);
		if ( !empty($pictureIdPicked) )
		{
			$conditionPicked = 'p1.id = :pictureIdPicked';
			$arrParameter['pictureIdPicked'] = $pictureIdPicked;
		}
		$alreadyVotedDuels = substr($alreadyVotedDuels, 0, -1);
		if ( empty($alreadyVotedDuels) ) $alreadyVotedDuels = "''";

		$query =
		"
			SELECT
				p1.id AS id1,
				p1.title AS title1,
				p1.short_description AS short_description1,
				p1.filename AS filename1,
				p2.id AS id2,
				p2.title AS title2,
				p2.short_description AS short_description2,
				p2.filename AS filename2
			FROM
				picture p1
			JOIN
				picture p2
			ON
				p2.picture_category_id = p1.picture_category_id
			AND
				p2.id <> p1.id
			AND
				p2.deleted_at IS NULL
			JOIN
				picture_category pc
			ON
				pc.id = p1.picture_category_id
			AND
				pc.deleted_at IS NULL
			AND
				pc.ident = :pictureCategory
			WHERE
				p1.deleted_at IS NULL
			AND
				$conditionPicked
			AND
				CONCAT(p1.id, 'v', p2.id) NOT IN ( $alreadyVotedDuels )
			ORDER BY
				p1.id DESC
			LIMIT 1
		";
		$data = DB::select($query, $arrParameter);
		if ( empty($data) ) return array();
		return (array)current($data);
	}

	/**
	 * Adds new visitor.
	 *
	 * @param string $userAgent
	 * @param string $remoteAddr
	 */
	public function addVisitor($userAgent, $remoteAddr)
	{
		DB::beginTransaction();
		$visitorId = null;
		try
		{
			$visitorId = $this->visitor->add($userAgent, $remoteAddr);
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
		return $visitorId;
	}

	/**
	 * Saves e-voting result.
	 *
	 * @param int $visitorId
	 * @param string $pictureCategory
	 * @param int $pictureIdWon
	 * @param int $pictureIdLost
	 * @param aray $arrAlreadyVotedDuels
	 * @return array feedback data
	 */
	public function saveVote($visitorId, $pictureCategory,
		$pictureIdWon, $pictureIdLost, array $arrAlreadyVotedDuels = array())
	{
		DB::beginTransaction();
		$data = array();
		try
		{
			$dataWon = $this->picture->getPicture($pictureIdWon);
			$dataLost = $this->picture->getPicture($pictureIdLost);
			$elo = new EloRating();
			$elo->setGame($dataWon['rating'], $dataLost['rating'],
				1, 25);
			$ratingWon = $elo->getEloPlayers(0);
			$ratingWon = $ratingWon['newElo'];
			$ratingLost = $elo->getEloPlayers(1);
			$ratingLost = $ratingLost['newElo'];

			$query =
			"
				UPDATE
					picture pWon
				JOIN
					picture pLost
				ON
					pLost.id = :pictureIdLost
				AND
					pLost.picture_category_id
						= pWon.picture_category_id
				JOIN
					picture_category pc
				ON
					pc.id = pWon.picture_category_id
				AND
					pc.ident = :pictureCategory
				SET
					pWon.rating = :ratingWon,
					pLost.rating = :ratingLost
				WHERE
					pWon.id = :pictureIdWon
			";
			if ( !in_array($pictureIdWon . 'v' . $pictureIdLost,
				$arrAlreadyVotedDuels) )
			{
				DB::statement($query, array(
					'pictureIdLost' => $pictureIdLost,
					'pictureCategory' => $pictureCategory,
					'ratingWon' => $ratingWon,
					'ratingLost' => $ratingLost,
					'pictureIdWon' => $pictureIdWon));

				$this->duelLog->create(
					array('visitor_id' => $visitorId,
						'picture_id_won' => $pictureIdWon,
						'picture_id_lost' => $pictureIdLost,
						'rating_won' => $ratingWon,
						'rating_lost' => $ratingLost)
				);
			}

			$model = $this->duelLog->getModel()->select(
				array( DB::raw('COUNT(id) AS numberSameVotes')))
				->where('picture_id_won', '=', $pictureIdWon)
				->where('picture_id_lost', '=', $pictureIdLost);
			$data = $model->get()->toArray();
			$numberSameVotes = 0;
			if ( isset($data[0]) )
			{
				$numberSameVotes = $data[0]['numberSameVotes'];
			}

			$model = $this->duelLog->getModel()->select(
				array( DB::raw('COUNT(id) AS numberNotSameVotes')))
				->where('picture_id_won', '=', $pictureIdLost)
				->where('picture_id_lost', '=', $pictureIdWon);
			$data = $model->get()->toArray();
			$numberNotSameVotes = 0;
			if ( isset($data[0]) )
			{
				$numberNotSameVotes = $data[0]['numberNotSameVotes'];
			}

			$percentSameVotes = 100;
			if ($numberSameVotes != 0 || $numberNotSameVotes != 0)
			{
				$percentSameVotes = round(100 * $numberSameVotes /
					($numberSameVotes + $numberNotSameVotes));
			}

			$dataWon['rating'] = $ratingWon;
			$dataLost['rating'] = $ratingLost;
			$data = array('won' => $dataWon,
				'lost' => $dataLost,
				'percentSameVotes' => $percentSameVotes);
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
		return $data;
	}

	/**
	 * Gets picture by id.
	 *
	 * @param int $pictureId
	 * @return array
	 */
	public function getPictureById($pictureId)
	{
		return $this->picture->getPicture($pictureId);
	}

	/**
	 * Gets picture category.
	 *
	 * @param int $pictureCategoryId
	 * @return string
	 */
	public function getPictureCategory($pictureCategoryId)
	{
		return $this->picture->getPictureCategory($pictureCategoryId);
	}

	/**
	 * Gets duel log.
	 *
	 * @param int $pictureId
	 * @param int $limit
	 * @return array
	 */
	public function getDuelLog($pictureId, $limit = 10)
	{
		if ( !InputChecker::isUnsignedInteger(array($pictureId, $limit)) )
		{
			return array();
		}
		$query =
		"
			SELECT
				IF
				(
					dl.picture_id_won = $pictureId,
					dl.rating_won,
					dl.rating_lost
				) AS rating,
				IF
				(
					dl.picture_id_won = $pictureId,
					1,
					0
				) AS won_yn,
				dl.created_at as date,
				IF
				(
					dl.picture_id_won = $pictureId,
					dl.picture_id_lost,
					dl.picture_id_won
				) AS picture_id_opponent
			FROM
				duel_log dl
			JOIN
				picture pWon
			ON
				pWon.id = dl.picture_id_won
			JOIN
				picture pLost
			ON
				pLost.id = dl.picture_id_lost
			WHERE
				dl.deleted_at IS NULL
			AND
				(pWon.id = $pictureId OR pLost.id = $pictureId)
			ORDER BY
				dl.created_at DESC
			LIMIT
				$limit
		";
		$data = DB::select($query);
		$dataDuelLog = array();
		$arrItem = array();
		foreach ($data as $row)
		{
			$arrItem[] = (array)$row;
		}
		$dataDuelLog['items'] = $arrItem;
		$dataDuelLog['rank'] = $this->getRank($pictureId);
		$dataNumberVotes = $this->getNumberVotes($pictureId);
		$dataDuelLog['won'] = $dataNumberVotes['won'];
		$dataDuelLog['lost'] = $dataNumberVotes['lost'];
		return $dataDuelLog;
	}

	/**
	 * Gets number votes.
	 *
	 * @param int $pictureId
	 * @return array
	 */
	public function getNumberVotes($pictureId)
	{
		$dataVotes = array('won' => 0, 'lost' => 0);
		if ( !InputChecker::isUnsignedInteger(array($pictureId)) )
		{
			return $dataVotes;
		}
		$query =
		"
			SELECT
				COUNT(id) AS numberWon
			FROM
				duel_log
			WHERE
				picture_id_won = :pictureId
			AND
				deleted_at IS NULL
		";
		$data = DB::select($query, array('pictureId' => $pictureId));
		if ( !empty($data) )
		{
			$dataVotes['won'] = $data[0]->numberWon;
		}
		$query =
		"
			SELECT
				COUNT(id) AS numberLost
			FROM
				duel_log
			WHERE
				picture_id_lost = :pictureId
			AND
				deleted_at IS NULL
		";
		$data = DB::select($query, array('pictureId' => $pictureId));
		if ( !empty($data) )
		{
			$dataVotes['lost'] = $data[0]->numberLost;
		}
		return $dataVotes;
	}

	/**
	 * Gets rank.
	 *
	 * @param int $pictureId
	 * @return int rank
	 */
	public function getRank($pictureId)
	{
		if ( !InputChecker::isUnsignedInteger(array($pictureId)) )
		{
			return array();
		}
		$query =
		"
			SELECT
				COUNT(pOpponent.id) + 1 AS rank
			FROM
				picture pOpponent
			JOIN
				picture pPicked
			ON
				pPicked.picture_category_id
					= pOpponent.picture_category_id
			AND
				pPicked.id != pOpponent.id
			AND
				pPicked.rating < pOpponent.rating
			AND
				pPicked.id = :pictureId
			AND
				pPicked.deleted_at IS NULL
			WHERE
				pOpponent.deleted_at IS NULL
		";
		$data = DB::select($query, array('pictureId' => $pictureId));
		if ( empty($data) ) return array();
		return $data[0]->rank;
	}
}
