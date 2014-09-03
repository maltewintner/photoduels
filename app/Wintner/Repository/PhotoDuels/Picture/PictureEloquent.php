<?php
/**
 * Picture
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Picture;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Wintner\Repository\Core\BasicRepositoryEloquent;
use Wintner\Repository\Core\ValidatorInterface;
use Wintner\Exception\ValidatorException;
use Wintner\Helper\InputChecker;
use Wintner\Repository\PhotoDuels\Search\IndexerInterface;

/**
 * Class representing a picture.
 */
class PictureEloquent extends BasicRepositoryEloquent
	implements PictureInterface
{
	/**
	 * @var IndexerInterface Indexer
	 */
	protected $indexer = null;

	/**
	 * Initializes the picture.
	 *
	 * @param Model $picture
	 * @param IndexerInterface $indexer
	 * @param ValidatorInterface $validator
	 */
	public function __construct(Model $picture, IndexerInterface $indexer,
		ValidatorInterface $validator)
	{
		parent::__construct($picture, $validator);
		$this->indexer = $indexer;
	}

	/**
	 * Gets latest picture for each category.
	 *
	 * @return array Picture data
	 */
	public function getLatestPictureForEachCategory()
	{
		$arrPictureCategory = $this->getArrayPictureCategory();
		$data = array();
		foreach ($arrPictureCategory as $pictureCategory)
		{
			$dataPicture = $this->getPictureByCategory($pictureCategory, 1, 1,
				array('picture.updated_at' => true, 'picture.id' => true));
			if ( !empty($dataPicture['items']) )
			{
				$data[] = $dataPicture['items'][0];
			}
		}
		return $data;
	}

	/**
	 * Gets picture category.
	 *
	 * @param int $pictureCategoryId
	 * @return string
	 */
	public function getPictureCategory($pictureCategoryId)
	{
		$arr = $this->getArrayPictureCategory();
		if ( isset($arr[$pictureCategoryId]) )
		{
			return $arr[$pictureCategoryId];
		}
		return null;
	}

	/**
	 * Gets picture category id.
	 *
	 * @param string $pictureCategory
	 * @return int
	 */
	public function getPictureCategoryId($pictureCategory)
	{
		$arr = $this->getArrayPictureCategory();
		$key = array_search($pictureCategory, $arr);
		if ($key !== false) return $key;
		return null;
	}

	/**
	 * Gets most popular pictures.
	 *
	 * @param string $pictureCategory
	 * @param int $page
	 * @param int $limit
	 * @return array Picture data
	 */
	public function getMostPopularPictures($pictureCategory,
		$page = 1, $limit = 5)
	{
		if ( !InputChecker::isUnsignedInteger(array($page, $limit)) )
		{
			throw new \InvalidArgumentException(
				'unsigned_integer_required');
		}
		$data = array();
		$model = $this->prepareModel()
			->where('picture_category.ident', $pictureCategory);
		$data['total'] = $model->count();
		$model = $model->orderBy('picture.rating', 'DESC')
			->skip($limit * ($page - 1))->take($limit);
		$data['items'] = $model->get()->toArray();
		return $data;
	}

	/**
	 * Gets most popular words.
	 *
	 * @param int $limit
	 * @return array Words
	 */
	public function getMostPopularWords($limit = 15)
	{
		$query =
		"
			SELECT
				w.word,
				COUNT(ii.id) AS occurence
			FROM
				word w
			JOIN
				inverted_index ii
			ON
				ii.word_id = w.id
			AND
				ii.deleted_at IS NULL
			WHERE
				w.deleted_at IS NULL
			GROUP BY
				w.id
			ORDER BY
				COUNT(w.id) DESC
			LIMIT
				:limit
		";
		$data = DB::select($query, array('limit' => $limit));
		$dataWord = array();
		foreach ($data as $row)
		{
			$dataWord[$row->word] = $row->occurence;
		}
		return $dataWord;
	}

	/**
	 * Gets picture categories.
	 *
	 * @return array Picture categories
	 */
	public function getArrayPictureCategory()
	{
		$query =
		"
			SELECT
				id,
				ident
			FROM
				picture_category
			WHERE
				deleted_at IS NULL
		";
		$data = DB::select($query);
		$arrPictureCategory = array();
		foreach ($data as $row)
		{
			$arrPictureCategory[$row->id] = $row->ident;
		}
		return $arrPictureCategory;
	}

	/**
	 * Gets picture by category.
	 *
	 * @param string $pictureCategory
	 * @param int $page
	 * @param int $limit
	 * @param array $arrColumnNameToSort
	 * @throws \InvalidArgumentException
	 * @return array
	 */
	private function getPictureByCategory($pictureCategory, $page = 1,
		$limit = 10, array $arrColumnNameToSort = array())
	{
		if ( !InputChecker::isUnsignedInteger(array($page, $limit)) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		$data = array();
		$model = $this->prepareModel()
			->where('picture_category.ident', $pictureCategory);
		$data['total'] = $model->count();
		foreach ($arrColumnNameToSort as $columnName => $isDesc)
		{
			$model = $model->orderBy($columnName,
				$isDesc ? 'desc' : 'asc');
		}
		$model = $model->skip($limit * ($page - 1))->take($limit);
		$data['items'] = $model->get()->toArray();
		return $data;
	}

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
		$title, $shortDescription, $description, UploadedFile $file = null)
	{
		if ( !InputChecker::isUnsignedInteger(array($userId, $pictureCategoryId)) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		$data = array(
			'user_id' => $userId,
			'file' => $file,
			'picture_category_id' => $pictureCategoryId,
			'title' => strip_tags($title),
			'short_description' => strip_tags($shortDescription),
			'description' => strip_tags($description));
		if ( !$this->validator->validate(
			PictureLaravelValidator::RULE_TYPE_ADD_PICTURE, $data) )
		{
			throw new ValidatorException($this->validator);
		}
		unset($data['file']);
		$data['filename'] = $file->getClientOriginalName();
		DB::beginTransaction();
		$pictureId = null;
		try
		{
			$this->insert($data);
			$this->updateIndex($this->getLastInsertId());
			$pictureId = $this->getLastInsertId();
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
		return $pictureId;
	}

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
		$shortDescription, $description)
	{
		if ( !InputChecker::isUnsignedInteger(array($userId, $pictureId)) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		if ( !$this->checkAccess($userId, $pictureId) )
		{
			$this->validator->addError('access_denied');
			throw new ValidatorException($this->validator);
		}
		$data = array(
			'user_id' => $userId,
			'id' => $pictureId,
			'title' => strip_tags($title),
			'short_description' => strip_tags($shortDescription),
			'description' => strip_tags($description));
		if ( !$this->validator->validate(
			PictureLaravelValidator::RULE_TYPE_EDIT_PICTURE, $data) )
		{
			throw new ValidatorException($this->validator);
		}
		DB::beginTransaction();
		try
		{
			$this->update($data);
			$this->updateIndex($pictureId);
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * Deletes picture.
	 *
	 * @param int $userId
	 * @param int $pictureId
	 * @return void
	 */
	public function deletePicture($userId, $pictureId)
	{
		if ( !InputChecker::isUnsignedInteger(array($userId, $pictureId)) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		if ( !$this->checkAccess($userId, $pictureId) )
		{
			$this->validator->addError('access_denied');
			throw new ValidatorException($this->validator);
		}
		DB::beginTransaction();
		try
		{
			$this->delete($pictureId);
			$this->updateIndex($pictureId);
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * Prepares model.
	 *
	 * @return Model
	 */
	private function prepareModel()
	{
		return $this->model->select
		(
			array
			(
				'picture.id',
				'picture.filename',
				'picture_category.ident AS pictureCategory',
				'picture.title',
				'picture.short_description',
				'picture.description',
				'picture.rating',
			)
		)->join('picture_category', 'picture.picture_category_id',
				'=', 'picture_category.id');
	}

	/**
	 * Gets account pictures.
	 *
	 * @param int $userId
	 * @param int $page
	 * @param int $limit
	 * @return array Picture data
	 */
	public function getAccountPictures($userId, $page = 1, $limit = 5)
	{
		if ( !InputChecker::isUnsignedInteger(array($userId, $page, $limit)) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		$data = array();
		$model = $this->prepareModel()
			->where('picture.user_id', $userId);
		$data['total'] = $model->count();
		$model = $model
			->orderBy('picture.id', 'DESC')
			->skip($limit * ($page - 1))->take($limit);
		$data['items'] = $model->get()->toArray();
		return $data;
	}

	/**
	 * Gets picture.
	 *
	 * @param int $pictureId
	 * @return array Picture data
	 */
	public function getPicture($pictureId)
	{
		if ( !InputChecker::isUnsignedInteger($pictureId) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		$model = $this->prepareModel()
			->where('picture.id', $pictureId);
		$data = $model->get()->toArray();
		return current($data);
	}

	/**
	 * Gets account picture.
	 *
	 * @param int $userId
	 * @param int $pictureId
	 * @return array Picture data
	 */
	public function getAccountPicture($userId, $pictureId)
	{
		if ( !InputChecker::isUnsignedInteger(array($userId, $pictureId)) )
		{
			throw new \InvalidArgumentException('unsigned_integer_required');
		}
		$model = $this->prepareModel()
			->where('picture.user_id', $userId)
			->where('picture.id', $pictureId);
		$data = $model->get()->toArray();
		if ( empty($data) ) return array();
		return current($data);
	}

	/**
	 * Checks if the access is allowed for a specific user.
	 *
	 * @param int $userId
	 * @param int $pictureId
	 * @return boolean
	 */
	private function checkAccess($userId, $pictureId)
	{
		$model = $this->model->select(
			array('id'))
			->where('user_id', $userId)
			->where('id', $pictureId);
		$data = $model->get()->toArray();
		return !empty($data);
	}

	/**
	 * Gets indexer.
	 *
	 * @return IndexerInterface $indexer
	 */
	public function getIndexer()
	{
		return $this->indexer;
	}

	/**
	 * Updates index.
	 *
	 * @param int $pictureId
	 */
	private function updateIndex($pictureId)
	{
		$data = $this->getPicture($pictureId);
		if ( empty($data) )
		{
			$this->indexer->delete($pictureId);
		} else
		{
			$this->indexer->index($pictureId, $data['pictureCategory']
				. ' ' . $data['title'] . ' ' . $data['short_description']
				. ' ' . $data['description']);
		}
	}
}
