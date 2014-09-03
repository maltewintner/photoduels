<?php
/**
 * Input Checker
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Helper;

/**
 * Helper class that provides basic input checks.
 */
class InputChecker
{
	/**
	 * Checks if input is an unsigned integer.
	 *
	 * @param int $value
	 * @return boolean
	 */
	public static function isUnsignedInteger($value)
	{
		if ( !is_array($value) )
		{
			$value = array($value);
		}
		foreach ($value as $item)
		{
			if ( !preg_match("!^[0-9]+$!", $item) )
			{
				return false;
			}
		}
		return true;
	}
}