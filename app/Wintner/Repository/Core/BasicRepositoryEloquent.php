<?php
/**
 * Eloquent Basic Repository
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\Core;

use Illuminate\Database\Eloquent\Model;
use Wintner\Exception\ValidatorException;
use Wintner\Helper\InputChecker;

/**
 * Class that provides basic database operations.
 */
abstract class BasicRepositoryEloquent implements BasicRepositoryInterface
{
	/**
	 * @var Model An Eloquent model
	 */
	protected $model = null;

	/**
	 * @var ValidatorInterface Validator
	 */
	protected $validator = null;

	/**
	 * @var int Last insert id
	 */
	protected $lastInsertId = null;

	/**
	 * Initializes the basic repository.
	 *
	 * @param Model $model
	 * @param ValidatorInterface $validator
	 */
	public function __construct(Model $model,
		ValidatorInterface $validator = null)
	{
		$this->model = $model;
		$this->validator = $validator;
	}

	/**
	 * Gets data by id.
	 *
	 * @param array $arrId
	 * @param int $page
	 * @param int $limit
	 * @param array $arrColumnNameToSort
	 * @return array
	 */
	public function getById(array $arrId, $page = 1, $limit = 10,
		array $arrColumnNameToSort)
	{
		if ( !InputChecker::isUnsignedInteger(array($page, $limit)) )
		{
			return array();
		}
		if ( empty($arrId) )
		{
			return array('items' => array(), 'total' => 0);
		}
		$data = array();
		$model = $this->model->whereIn('id', $arrId);
		$data['total'] = $model->count();
		$model = $model
			->skip($limit * ($page - 1))->take($limit);
		foreach ($arrColumnNameToSort as $columnName => $isDesc)
		{
			$model = $model->orderBy($columnName,
				$isDesc ? 'desc' : 'asc');
		}
		$data['items'] = $model->get()->toArray();
		return $data;
	}

	/**
	 * Gets paginated data.
	 *
	 * @param number $page
	 * @param number $limit
	 * @param array $arrColumnNameToSort
	 * @return array
	 */
	public function get($page = 1, $limit = 10, array $arrColumnNameToSort)
	{
		if ( !InputChecker::isUnsignedInteger(array($page, $limit)) )
		{
			return array();
		}
		$data = array();
		$data['total'] = $this->model->count();
		$model = $this->model->skip($limit * ($page - 1))->take($limit);
		foreach ($arrColumnNameToSort as $columnName => $isDesc)
		{
			$model = $model->orderBy($columnName,
				$isDesc ? 'desc' : 'asc');
		}
		$data['items'] = $model->get()->toArray();
		return $data;
	}

	/**
	 * Inserts data.
	 *
	 * @param array $input
	 * @return void
	 */
	public function insert(array $input)
	{
		$this->lastInsertId = $this->model->create($input)->id;
	}

	/**
	 * Updates data.
	 *
	 * @param array $input
	 * @return void
	 */
	public function update(array $input)
	{
		if ( !isset($input['id']) ) return;
		$model = $this->model->find($input['id']);
		if ($model != null)
		{
			$model->update($input);
		}
	}

	/**
	 * Deletes data.
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete($id)
	{
		if ( !InputChecker::isUnsignedInteger($id) ) return;
		$model = $this->model->find($id);
		if ($model != null) $model->delete();
	}

	/**
	 * Gets last insert id.
	 *
	 * @return int
	 */
	public function getLastInsertId()
	{
		return $this->lastInsertId;
	}

	/**
	 * Returns the model
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getModel()
	{
		return $this->model;
	}
}
