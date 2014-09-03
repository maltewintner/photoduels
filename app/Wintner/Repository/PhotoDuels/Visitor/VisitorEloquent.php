<?php
/**
 * Eloquent visitor
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\Repository\PhotoDuels\Visitor;

use Illuminate\Database\Eloquent\Model;
use Wintner\Repository\Core\BasicRepositoryEloquent;
use Wintner\Repository\Core\ValidatorInterface;

/**
 * Class representing a visitor.
 */
class VisitorEloquent extends BasicRepositoryEloquent implements VisitorInterface
{
	/**
	 * Initializes a visitor.
	 *
	 * @param Model $visitor
	 * @param ValidatorInterface $validator
	 */
	public function __construct(Model $visitor, ValidatorInterface $validator)
	{
		parent::__construct($visitor, $validator);
	}

	/**
	 * Adds a new visitor.
	 *
	 * @param string $userAgent
	 * @param string $remoteAddr
	 * @return int $visitorId
	 */
	public function add($userAgent, $remoteAddr)
	{
		$this->insert(array(
				'user_agent' => $userAgent,
				'remote_addr' => $remoteAddr,
			));
		return $this->getLastInsertId();
	}

}
