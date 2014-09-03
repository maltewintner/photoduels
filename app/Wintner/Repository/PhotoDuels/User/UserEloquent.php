<?php
/**
 * User
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Wintner\Repository\Core\BasicRepositoryEloquent;
use Wintner\Repository\Core\ValidatorInterface;
use Wintner\Exception\ValidatorException;

/**
 * Class representing an user.
 */
class UserEloquent extends BasicRepositoryEloquent implements UserInterface
{
	/**
	 * @var Guard Provides authentication in Laravel.
	 */
	private $auth = null;

	/**
	 * Initializes the user.
	 *
	 * @param Model $user
	 * @param ValidatorInterface $validator
	 * @param Guard $auth
	 */
	public function __construct(Model $user,
		ValidatorInterface $validator, Guard $auth)
	{
		parent::__construct($user, $validator);
		$this->auth = $auth;
	}

	/**
	 * Logs in to the application.
	 *
	 * @param string $email
	 * @param string $password
	 * @throws ValidatorException
	 * @return int $userId
	 */
	public function login($email, $password)
	{
		if ( !$this->auth->attempt(array('email' => $email,
			'password' => $password)) )
		{
			$this->validator->addError('wrong_credentials');
			throw new ValidatorException($this->validator);
		}
		return $this->auth->user()->id;
	}

	/**
	 * Logs out.
	 *
	 * @return void
	 */
	public function logout()
	{
		if ( $this->auth->check() ) $this->auth->logout();
	}

	/**
	 * Registers a new user.
	 *
	 * @param string $email
	 * @param string $username
	 * @param string $password
	 * @param string $passwordConfirmation
	 * @return int $userId
	 */
	public function register($email, $username,
		$password, $passwordConfirmation)
	{
		$data = array('email' => $email, 'username' => $username,
			'password' => $password,
			'password_confirmation' => $passwordConfirmation);
		if ( !$this->validator->validate(
			UserLaravelValidator::RULE_TYPE_REGISTER, $data) )
		{
			throw new ValidatorException($this->validator);
		}
		$data['password'] = Hash::make($password);
		DB::beginTransaction();
		$userId = null;
		try
		{
			unset($data['password_confirmation']);
			$this->model->create($data);
			$userId = $this->login($email, $password);
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
		return $userId;
	}

	/**
	 * Updates the profile.
	 *
	 * @param string $email
	 * @param string $password
	 * @param string $passwordConfirmation
	 */
	public function updateProfile($email, $password = null,
		$passwordConfirmation = null)
	{
		$data = array('email' => $email,
			'password' => $password,
			'password_confirmation' => $passwordConfirmation);
		$this->validator->setUserId($this->auth->user()->id);
		if ( !$this->validator->validate(
			UserLaravelValidator::RULE_TYPE_PROFILE, $data) )
		{
			throw new ValidatorException($this->validator);
		}
		$data = array('id' => $this->auth->id(),
			'email' => $email);
		if ( !empty($password) )
		{
			$data['password'] = Hash::make($password);
		}
		DB::beginTransaction();
		try
		{
			$this->update($data);
			$this->auth->user()->email = $email;
		} catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * Gets username.
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->auth->user()->username;
	}

	/**
	 * Gets email.
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->auth->user()->email;
	}
}
