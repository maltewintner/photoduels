<?php
/**
 * Stop words interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Describes stop words.
 */
interface StopWordsInterface
{
	/**
	 * Gets stop words.
	 *
	 * @return array
	 */
	public function getArrayStopWords();
}
