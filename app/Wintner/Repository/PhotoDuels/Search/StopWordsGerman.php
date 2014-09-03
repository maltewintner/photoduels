<?php
/**
 * German stop words
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

/**
 * Class representing German stop words.
 */
class StopWordsGerman extends StopWords
{
	/**
	 * @var array Stop words
	 */
	protected $arrStopWords = array
		(
			'mit', 'ein', 'eine', 'der', 'die', 'das', 'zu', 'zur', 'zum',
			'von', 'im', 'da', 'auf', 'mehr', 'er', 'sie', 'es', 'den',
			'für', 'vor', 'wie', 'wird', 'werde', 'werden', 'aus',
			'uns', 'per', 'ohne', 'nicht', 'dir'
		);
}
