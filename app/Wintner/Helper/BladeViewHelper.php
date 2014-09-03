<?php
/**
 * Blade View Helper
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Helper;

use Illuminate\Support\Facades\Route;

/**
 * Helper class that provides extended functions for blade templates.
 */
class BladeViewHelper
{

	/**
	 * Checks if the current route exists in a list of routes.
	 *
	 * @param array $arrRouteName A list of route names.
	 * @param string $successValue The value to be returned if there is a match.
	 * @param string $failedValue The value to be returned if there is no match.
	 * @return string
	 */
	public static function checkRoute(array $arrRouteName, $successValue,
		$failedValue = '')
	{
		$route = Route::current();
		if ($route == null) return $failedValue;
		if ( in_array($route->getName(), $arrRouteName) )
		{
			return $successValue;
		}
		return $failedValue;
	}
}