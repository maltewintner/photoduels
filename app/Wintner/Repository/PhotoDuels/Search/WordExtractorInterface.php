<?php
/**
 * Word extractor interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Describes a word extractor interface.
 */
interface WordExtractorInterface
{
	/**
	 * Extracts words from a text.
	 *
	 * @param string $text
	 * @return array Words
	 */
	public function extract($text);
}