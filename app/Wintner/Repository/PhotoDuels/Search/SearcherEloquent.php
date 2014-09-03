<?php
/**
 * Searcher
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

use Illuminate\Support\Facades\DB;
use Wintner\Repository\PhotoDuels\Picture\PictureInterface;

/**
 * Class representing a searcher.
 */
class SearcherEloquent implements SearcherInterface
{
	/**
	 * @var PictureInterface Picture model
	 */
	protected $picture = null;

	/**
	 * Initializes the searcher.
	 *
	 * @param PictureInterface $picture
	 */
	public function __construct(PictureInterface $picture)
	{
		$this->picture = $picture;
	}

	/**
	 * Processes a full-text search.
	 *
	 * @param string $query
	 * @param int $page
	 * @param int $limit
	 */
	public function search($query, $page = 1, $limit = 5)
	{
		$arrPictureId = array();
		$total = 0;
		$arrWord = $this->picture->getIndexer()->extractWords($query);
		$arrPictureId = array();
		foreach ($arrWord as $word)
		{
			$arrPictureId = array_merge($arrPictureId,
				$this->seek($word));
		}
		return $this->picture->getById($arrPictureId,
			$page, $limit, array('updated_at' => true));
	}

	/**
	 * Seeks pictures containing a given word.
	 *
	 * @param string $word
	 * @return array Picture ids
	 */
	private function seek($word)
	{
		$arrPictureId = array();
		$query =
		"
			SELECT DISTINCT
				ii.picture_id
			FROM
				inverted_index ii
			JOIN
				word w
			ON
				w.id = ii.word_id
			AND
				w.deleted_at IS NULL
			AND
				w.word LIKE ?
			WHERE
				ii.deleted_at IS NULL
			ORDER BY
				ii.updated_at DESC
		";
		$data = DB::select($query, array('%' . $word . '%'));
		$arrPictureId = array();
		foreach ($data as $row)
		{
			$arrPictureId[] = $row->picture_id;
		}
		return $arrPictureId;
	}
}
