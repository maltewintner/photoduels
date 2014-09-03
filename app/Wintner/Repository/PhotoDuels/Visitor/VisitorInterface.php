<?php
/**
 * Visitor Interface
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Visitor;

/**
 * Describes a visitor instance.
 */
interface VisitorInterface
{

	/**
	 * Adds a new visitor.
	 *
	 * @param string $userAgent
	 * @param string $remoteAddr
	 * @return int $visitorId
	 */
	public function add($userAgent, $remoteAddr);
}
