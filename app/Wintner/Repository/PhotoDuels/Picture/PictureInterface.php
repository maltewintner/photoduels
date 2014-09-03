<?php
/**
 * Picture Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Picture;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Describes a picture instance.
 */
interface PictureInterface
{
	/**
	 * Gets latest picture for each category.
	 *
	 * @return array Picture data
	 */
	public function getLatestPictureForEachCategory();

	/**
	 * Gets picture.
	 *
	 * @param int $pictureId
	 * @return array Picture data
	 */
	public function getPicture($pictureId);

	/**
	 * Gets picture category.
	 *
	 * @param int $pictureCategoryId
	 * @return string
	 */
	public function getPictureCategory($pictureCategoryId);

	/**
	 * Gets picture category id.
	 *
	 * @param string $pictureCategory
	 * @return int
	 */
	public function getPictureCategoryId($pictureCategory);

	/**
	 * Gets most popular pictures.
	 *
	 * @param string $pictureCategory
	 * @param int $page
	 * @param int $limit
	 * @return array Picture data
	 */
	public function getMostPopularPictures($pictureCategory,
		$page = 1, $limit = 5);

	/**
	 * Gets most popular words.
	 *
	 * @param int $limit
	 * @return array Words
	 */
	public function getMostPopularWords($limit = 15);

	/**
	 * Gets picture categories.
	 *
	 * @return array Picture categories
	 */
	public function getArrayPictureCategory();

	/**
	 * Adds new picture.
	 *
	 * @param int $userId
	 * @param UploadedFile $file
	 * @param int $pictureCategoryId
	 * @param string $title
	 * @param string $shortDescription
	 * @param string $description
	 * @return int $pictureId
	 */
	public function addPicture($userId, $pictureCategoryId,
		$title, $shortDescription, $description,
		UploadedFile $file = null);

	/**
	 * Updates picture.
	 *
	 * @param int $userId
	 * @param int $pictureId
	 * @param string $title
	 * @param string $shortDescription
	 * @param string $description
	 * @return void
	 */
	public function updatePicture($userId, $pictureId, $title,
		$shortDescription, $description);

	/**
	 * Deletes picture.
	 *
	 * @param int $userId
	 * @param int $pictureId
	 * @return void
	 */
	public function deletePicture($userId, $pictureId);

	/**
	 * Gets account pictures.
	 *
	 * @param int $userId
	 * @param int $page
	 * @param int $limit
	 * @return array Picture data
	 */
	public function getAccountPictures($userId, $page = 1, $limit = 5);

	/**
	 * Gets account picture.
	 *
	 * @param int $userId
	 * @param int $pictureId
	 * @return array Picture data
	 */
	public function getAccountPicture($userId, $pictureId);

	/**
	 * Gets indexer.
	 *
	 * @return IndexerInterface $indexer
	 */
	public function getIndexer();
}
