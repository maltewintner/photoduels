<?php
/**
 * User Laravel Validator
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\User;

use Illuminate\Validation\Factory;
use Wintner\Repository\Core\LaravelValidator;

/**
 * Class representing an user validator.
 */
class UserLaravelValidator extends LaravelValidator
{
	const RULE_TYPE_REGISTER = 'register';
	const RULE_TYPE_PROFILE = 'profile';
	const RULE_TYPE_NONE = 'none';

	/**
	 * @var array Validation rules
	 */
	protected $rules = array(
			'register' => array(
				'email' => 'required|email|unique:user',
				'username' => 'required|alpha_num|between:4,20|unique:user',
				'password'=>'required|alpha_num|between:6,20|confirmed'),
			'profile' => array(
				'email' => 'required|email|unique:user',
				'password'=>'alpha_num|between:6,20|confirmed'),
		);

	/**
	 * Sets user id.
	 *
	 * @param int $userId
	 * @return void
	 */
	public function setUserId($userId)
	{
		$this->rules['profile']['email']
			= 'required|email|unique:user,email,' . $userId;
	}
}
