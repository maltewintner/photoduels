<?php
/**
 * Laravel Indexer
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Search;

use Illuminate\Support\Facades\DB;
use Wintner\Helper\InputChecker;

/**
 * Class responsible for indexing picture related text.
 */
class IndexerLaravel implements IndexerInterface
{
	const MIN_WORD_LENGTH = 3;

	/**
	 * @var StopWordsInterface Contains language specific stop words.
	 */
	protected $stopWords = null;

	/**
	 * @var WordExtractorInterface Word extractor
	 */
	protected $wordExtractor = null;

	/**
	 * Initializes the indexer.
	 *
	 * @param StopWordsInterface $stopWords
	 * @param WordExtractorInterface $wordExtractor
	 */
	public function __construct(StopWordsInterface $stopWords,
		WordExtractorInterface $wordExtractor)
	{
		$this->stopWords = $stopWords;
		$this->wordExtractor = $wordExtractor;
	}

	/**
	 * Adds picture related text to the index.
	 *
	 * @param int $pictureId
	 * @param string $text
	 * @return void
	 */
	public function index($pictureId, $text)
	{
		$this->delete($pictureId);
		$arrWord = $this->extractWords($text);
		if ( empty($arrWord) ) return;
		$values = '';
		$set = '';
		foreach ($arrWord as $word)
		{
			$word = DB::connection()->getPdo()->quote($word);
			$values .= '(' . $word . '),';
			$set .= $word . ',';
		}
		$values = substr($values, 0, -1);
		$set = substr($set, 0, -1);

		$query =
		"
			INSERT INTO word
			(word)
			VALUES
			$values
			ON DUPLICATE KEY UPDATE count = count + 1
		";
		DB::statement($query);

		$query =
		"
			INSERT INTO inverted_index
			(word_id, picture_id)
			SELECT
				id,
				$pictureId
			FROM
				word
			WHERE
				word IN ( $set )
			ON DUPLICATE KEY UPDATE inverted_index.count
				= inverted_index.count + 1
		";
		DB::statement($query);
	}

	/**
	 * Deletes picture related text from the index.
	 *
	 * @param int $pictureId
	 * @return void
	 */
	public function delete($pictureId)
	{
		if ( !InputChecker::isUnsignedInteger($pictureId) )
		{
			throw new \InvalidArgumentException('UNSIGNED_INTEGER_REQUIRED');
		}
		$query =
		"
			DELETE
				ii
			FROM
				inverted_index ii
			WHERE
				ii.picture_id = $pictureId
		";
		DB::statement($query);
	}

	/**
	 * Extracts words.
	 *
	 * @param string $text
	 * @return array Array of words
	 */
	public function extractWords($text)
	{
		$arrWord = array_diff($this->wordExtractor->extract($text),
			$this->stopWords->getArrayStopWords());
		foreach ($arrWord as $key => $word)
		{
			if ( strlen($word) < self::MIN_WORD_LENGTH )
			{
				unset($arrWord[$key]);
			}
		}
		return array_values($arrWord);
	}
}
