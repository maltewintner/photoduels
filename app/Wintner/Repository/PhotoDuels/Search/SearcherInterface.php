<?php
/**
 * Searcher Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Describes a searcher instance.
 */
interface SearcherInterface
{
	/**
	 * Processes a full-text search.
	 *
	 * @param string $query
	 * @param int $page
	 * @param int $limit
	 */
	public function search($query, $page = 1, $limit = 5);
}
