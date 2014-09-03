<?php
/**
 * User Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\User;

/**
 * Describes an user instance.
 */
interface UserInterface
{
	/**
	 * Logs in to the application.
	 *
	 * @param string $email
	 * @param string $password
	 * @throws ValidatorException
	 * @return int $userId
	 */
	public function login($email, $password);

	/**
	 * Logs out.
	 *
	 * @return void
	 */
	public function logout();

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
		$password, $passwordConfirmation);

	/**
	 * Gets username.
	 *
	 * @return string
	 */
	public function getUsername();

	/**
	 * Gets email.
	 *
	 * @return string
	 */
	public function getEmail();

	/**
	 * Updates the profile.
	 *
	 * @param string $email
	 * @param string $password
	 * @param string $passwordConfirmation
	 */
	public function updateProfile($email, $password = null,
		$passwordConfirmation = null);
}
