<?php
/**
 * Stop words
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Class representing stop words.
 */
abstract class StopWords implements StopWordsInterface
{
	/**
	 * @var array stop words
	 */
	protected $arrStopWords = array();

	/**
	 * Gets stop words.
	 *
	 * @return array
	 */
	public function getArrayStopWords()
	{
		return $this->arrStopWords;
	}
}
