<?php
/**
 * Duel Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Duel;

/**
 * Describes a picture duel.
 */
interface DuelInterface
{
	/**
	 * Gets next duel.
	 *
	 * @param string $pictureCategory
	 * @param array $arrAlreadyVotedDuels
	 * @param int $pictureIdPicked
	 * @return array Duel data
	 */
	public function getDuel($pictureCategory,
		array $arrAlreadyVotedDuels, $pictureIdPicked = null);

	/**
	 * Adds new visitor.
	 *
	 * @param string $userAgent
	 * @param string $remoteAddr
	 */
	public function addVisitor($userAgent, $remoteAddr);

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
	public function saveVote($visitorId,
		$pictureCategory, $pictureIdWon,
		$pictureIdLost, array $arrAlreadyVotedDuels);

	/**
	 * Gets picture by id.
	 *
	 * @param int $pictureId
	 * @return array
	 */
	public function getPictureById($pictureId);

	/**
	 * Gets picture category.
	 *
	 * @param int $pictureCategoryId
	 * @return string
	 */
	public function getPictureCategory($pictureCategoryId);

	/**
	 * Gets duel log.
	 *
	 * @param int $pictureId
	 * @param int $limit
	 * @return array
	 */
	public function getDuelLog($pictureId, $limit = 10);

	/**
	 * Gets rank.
	 *
	 * @param int $pictureId
	 * @return int rank
	 */
	public function getRank($pictureId);

	/**
	 * Gets number votes.
	 *
	 * @param int $pictureId
	 * @return array
	 */
	public function getNumberVotes($pictureId);
}
