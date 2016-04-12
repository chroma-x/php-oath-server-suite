<?php

namespace OathServerSuite\QrRender\PathFinder;

/**
 * Class PathPoint
 *
 * @package OathServerSuite\QrRender\PathFinder
 */
class PathPoint
{

	/**
	 * @var int
	 */
	private $x;

	/**
	 * @var int
	 */
	private $y;

	/**
	 * PathPoint constructor.
	 *
	 * @param int $x
	 * @param int $y
	 */
	public function __construct($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
	}

	/**
	 * @return int
	 */
	public function getX()
	{
		return $this->x;
	}

	/**
	 * @return int
	 */
	public function getY()
	{
		return $this->y;
	}

}
