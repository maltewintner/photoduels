<?php
/**
 * Basic Repository Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\Core;

/**
 * Describes a basic repository.
 */
interface BasicRepositoryInterface
{

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
		array $arrColumnNameToSort);

	/**
	 * Gets paginated data.
	 *
	 * @param number $page
	 * @param number $limit
	 * @param array $arrColumnNameToSort
	 * @return array
	 */
	public function get($page = 1, $limit = 10,
		array $arrColumnNameToSort);

	/**
	 * Inserts data.
	 *
	 * @param array $input
	 * @return void
	 */
	public function insert(array $input);

	/**
	 * Updates data.
	 *
	 * @param array $input
	 * @return void
	 */
	public function update(array $input);

	/**
	 * Deletes data.
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete($id);

	/**
	 * Gets last insert id.
	 *
	 * @return int
	 */
	public function getLastInsertId();
}
