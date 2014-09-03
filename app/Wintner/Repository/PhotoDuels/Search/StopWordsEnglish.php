<?php
/**
 * English stop words
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Class representing English stop words.
 */
class StopWordsEnglish extends StopWords
{
	/**
	 * @var array Stop words
	 */
	protected $arrStopWords = array
		(
			'i', 'a', 'about', 'an', 'and', 'are', 'as', 'at', 'be', 'by',
			'de', 'en', 'for', 'from', 'how', 'in', 'is', 'it', 'la', 'of',
			'on', 'or', 'that', 'the', 'this', 'to', 'was', 'what', 'when',
			'where', 'who', 'will', 'with', 'the', 'more', 'but', 'your',
			'been', 'has', 'can', 'all', 'also', 'its', 'have', 'one', 'most',
			'you', 'now', 'just', 'than', 'which', 'other', 'not', 'these',
			'any', 'while', 'through', 'too', 'still', 'there', 'they',
			'like', 'already', 'their',
		);
}
