<?php
/**
 * Validator Exception
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Exception;

use Wintner\Repository\Core\ValidatorInterface;

/**
 * Represents an exception coming from a validator.
 */
class ValidatorException extends \Exception
{
	/**
	 * @var ValidatorInterface The validator that has thrown the exception.
	 */
	protected $validator = null;

	/**
	 * Sets up the exception.
	 *
	 * @param ValidatorInterface $validator
	 */
	public function __construct(ValidatorInterface $validator)
	{
		parent::__construct(
			json_encode($validator->getErrors()));
		$this->validator = $validator;
	}

	/**
	 * Gets the validator.
	 *
	 * @return ValidatorInterface
	 */
	public function getValidator()
	{
		return $this->validator;
	}
}
