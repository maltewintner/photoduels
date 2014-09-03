<?php
/**
 * Simple Word Extractor
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Class representing a simple word extractor.
 */
class SimpleWordExtractor implements WordExtractorInterface
{
	/**
	 * Extracts words from a text.
	 *
	 * @param string $text
	 * @return array Words
	 */
	public function extract($text)
	{
		$arrWord = array();
		$text = strip_tags($text);
		$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
		$text = strtolower( trim($text) );
		$text = str_replace("ß", "ss", $text);
		$text = preg_replace("![^a-z0-9äöü\s]!iu", '', $text);
		$text = preg_replace("![\s]+!ius", ' ', $text);
		return explode(' ', $text);
	}
}