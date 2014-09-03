<?php
/**
 * Picture Laravel Validator
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Picture;

use Wintner\Repository\Core\LaravelValidator;

/**
 * Class representing a validator.
 */
class PictureLaravelValidator extends LaravelValidator
{
	const RULE_TYPE_ADD_PICTURE = 'add_picture';
	const RULE_TYPE_EDIT_PICTURE = 'edit_picture';

	/**
	 * @var array Validation rules
	 */
	protected $rules = array(
		'add_picture' => array(
				'user_id' => 'required|integer',
				'file' => 'required|mimes:jpg,jpeg|max:3000',
				'title' => 'required',
				'short_description' => 'required',
				'description' => 'required',
			),
		'edit_picture' => array(
				'user_id' => 'required|integer',
				'title' => 'required',
				'short_description' => 'required',
				'description' => 'required',
			),
	);
}
