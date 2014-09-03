<?php
/**
 * Laravel Validator
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\Core;

use Illuminate\Validation\Factory;

/**
 * Class responsible for the validation.
 */
abstract class LaravelValidator implements ValidatorInterface
{
	/**
	 * @var array Validation rules
	 */
	protected $rules = array();

	/**
	 * @var Factory Laravel validator
	 */
	protected $validator = null;

	/**
	 * @var array Validation errors
	 */
	protected $arrError = array();

	/**
	 * @var array validation data
	 */
	protected $data = array();

	/**
	 * Initializes the Laravel validator.
	 *
	 * @param Factory $validator
	 */
	public function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}

	 /**
     * Validates data.
     *
     * @param string $type Validation type
     * @param array $input Data to be validated
     * @return boolean
     */
	public function validate($type, array $input)
	{
		if ( !isset($this->rules[$type]) ) return false;
		$this->data = $input;
		$validator = $this->validator->make($this->data,
			$this->rules[$type]);
		if ( $validator->fails() )
		{
			$errors = $validator->failed();
			$arrError = array();
			foreach ($errors as $ident => $arrType)
			{
				$arrType = array_keys($arrType);
				foreach ($arrType as $type)
				{
					$arrError[] = strtolower($ident . '_' . $type);
				}
			}
			$this->arrError = array_unique(
				array_merge($this->arrError, $arrError));
			return false;
		}
		return true;
	}

	/**
     * Gets errors.
     *
     * @return array
     */
	public function getErrors()
	{
		return $this->arrError;
	}

	/**
	 * Adds error.
	 *
	 * @param string $ident
	 * @return void
	 */
	public function addError($ident)
	{
		$this->arrError[] = $ident;
		$this->arrError = array_unique($this->arrError);
	}

	/**
	 * Gets field value.
	 *
	 * @param string $ident
	 * @return string
	 */
	public function getValue($ident)
	{
		if ( isset($this->data[$ident]) )
		{
			return $this->data[$ident];
		}
		return null;
	}
}
