<?php
/**
 * Indexer Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Describes an indexer instance.
 */
interface IndexerInterface
{
	/**
	 * Adds picture related text to the index.
	 *
	 * @param int $pictureId
	 * @param string $text
	 * @return void
	 */
	public function index($pictureId, $text);

	/**
	 * Deletes picture related text from the index.
	 *
	 * @param int $pictureId
	 * @return void
	 */
	public function delete($pictureId);

	/**
	 * Extracts words.
	 *
	 * @param string $text
	 * @return array Array of words
	 */
	public function extractWords($text);
}
