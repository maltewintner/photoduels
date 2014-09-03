<?php
/**
 * Visitor Laravel Validator
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Visitor;

use Wintner\Repository\Core\LaravelValidator;

/**
 * Class representing a visitor validator.
 */
class VisitorLaravelValidator extends LaravelValidator
{
	/**
	 * @var array Validation rules
	 */
	protected $rules = array();
}
