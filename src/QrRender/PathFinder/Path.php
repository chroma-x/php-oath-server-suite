<?php

namespace OathServerSuite\QrRender\PathFinder;

/**
 * Class Path
 *
 * @package OathServerSuite\QrRender\PathFinder
 */
class Path
{

	/**
	 * @var PathPoint[]
	 */
	private $points = array();

	/**
	 * @return PathPoint[]
	 */
	public function getPoints()
	{
		return $this->points;
	}

	/**
	 * @return PathPoint
	 */
	public function getFirstPoint()
	{
		return $this->getPoint(0);
	}

	/**
	 * @param int $index
	 * @return PathPoint
	 */
	public function getPoint($index)
	{
		if (!isset($this->points[$index])) {
			return null;
		}
		return $this->points[$index];
	}

	/**
	 * @return int
	 */
	public function countPoints()
	{
		return count($this->points);
	}

	/**
	 * @param PathPoint[] $points
	 * @return $this
	 */
	public function setPoints($points)
	{
		$this->points = $points;
		return $this;
	}

	/**
	 * @param PathPoint $point
	 */
	public function addPoint(PathPoint $point)
	{
		$this->points[] = $point;
	}

}
