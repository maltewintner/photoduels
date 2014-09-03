<?php
/**
 * Validator Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\Core;

/**
 * Describes a validator instance.
 */
interface ValidatorInterface
{

    /**
     * Validates data.
     *
     * @param string $type Validation type
     * @param array $input Data to be validated
     * @return boolean
     */
	public function validate($type, array $input);

    /**
     * Gets errors.
     *
     * @return array
     */
	public function getErrors();

	/**
	 * Adds error.
	 *
	 * @param string $ident
	 * @return void
	 */
	public function addError($ident);

	/**
	 * Gets field value.
	 *
	 * @param string $ident
	 * @return string
	 */
	public function getValue($ident);
}
