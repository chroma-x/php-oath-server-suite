<?php

namespace OathServerSuite\QrRender\PathFinder;

use OathServerSuite\QrEncode\QrCode\QrCode;

/**
 * Class QrCodePathFinder
 *
 * @package OathServerSuite\QrRender\PathFinder
 */
class QrCodePathFinder
{

	const DIRECTION_RIGHT = 0;
	const DIRECTION_DOWN = 1;
	const DIRECTION_LEFT = 2;
	const DIRECTION_UP = 3;

	/**
	 * @var QrCode
	 */
	private $qrCode;

	/**
	 * @var Path[]
	 */
	protected $paths;

	/**
	 * @var array
	 */
	protected $visited;

	/**
	 * @param QrCode $qrCode
	 * @return Path[]
	 */
	public function perform(QrCode $qrCode)
	{
		$this->qrCode = $qrCode;
		$this->paths = array();
		$this->visited = array();
		for ($h = 1; $h < $qrCode->getHeight() - 1; $h++) {
			$this->visited[$h] = array();
		}

		$this->findPaths();
		return $this->paths;
	}

	private function findPaths()
	{
		for ($y = 1; $y <= $this->qrCode->getHeight(); $y++) {
			$qrCodePointRow = $this->qrCode->getRow($y);
			for ($x = 1; $x <= $this->qrCode->getWidth(); $x++) {
				if (!isset($this->visited[$y][$x])) {
					$qrCodePoint = $qrCodePointRow->getPoint($x);
					if ($this->isCorner($x, $y)) {
						$this->paths[] = $this->traceComposite($x, $y, $qrCodePoint->isActive());
						$this->visited[$y][$x] = true;
					}
				}
			}
		}
	}

	/**
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	private function isCorner($x, $y)
	{
		$currentPoint = $this->qrCode->getRow($y)->getPoint($x);
		$neighbourPoint = $this->qrCode->getRow($y - 1)->getPoint($x - 1);
		if ($neighbourPoint == $this->qrCode->getRow($y)->getPoint($x - 1) && $neighbourPoint == $this->qrCode->getRow($y - 1)->getPoint($x)) {
			if ($neighbourPoint != $currentPoint) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param int $startX
	 * @param int $startY
	 * @param bool $active
	 * @return array
	 */
	private function traceComposite($startX, $startY, $active)
	{

		$x = $startX;
		$y = $startY;
		$switched = !$active;

		$direction = self::DIRECTION_RIGHT;

		$path = new Path();
		$path->addPoint($this->getPoint($x, $y));

		do {
			switch ($direction) {
				case self::DIRECTION_RIGHT:
					$current = $this->qrCode->getRow($y)->getPoint($x);
					$other = $this->qrCode->getRow($y - 1)->getPoint($x);
					if ($current != $other) {
						$switched = $other;
						$x++;
					} else {
						$path->addPoint($this->getPoint($x, $y));
						$direction = ($switched == $other) ? self::DIRECTION_DOWN : self::DIRECTION_UP;
					}
					break;
				case self::DIRECTION_UP:
					$current = $this->qrCode->getRow($y - 1)->getPoint($x);
					$other = $this->qrCode->getRow($y - 1)->getPoint($x - 1);
					if ($current != $other) {
						$switched = $other;
						$y--;
					} else {
						$path->addPoint($this->getPoint($x, $y));
						$direction = ($switched == $other) ? self::DIRECTION_RIGHT : self::DIRECTION_LEFT;
						if ($direction == self::DIRECTION_RIGHT && $this->isCorner($x, $y)) {
							$this->visited[$y][$x] = true;
						}
					}
					break;
				case self::DIRECTION_LEFT:
					$current = $this->qrCode->getRow($y - 1)->getPoint($x - 1);
					$other = $this->qrCode->getRow($y)->getPoint($x - 1);
					if ($current != $other) {
						$switched = $other;
						$x--;
					} else {
						$path->addPoint($this->getPoint($x, $y));
						$direction = ($switched == $other) ? self::DIRECTION_UP : self::DIRECTION_DOWN;
						if ($direction == self::DIRECTION_DOWN && $this->isCorner($x, $y)) {
							$this->visited[$y][$x] = true;
						}
					}
					break;
				case self::DIRECTION_DOWN:
					$current = $this->qrCode->getRow($y)->getPoint($x - 1);
					$other = $this->qrCode->getRow($y)->getPoint($x);
					if ($current != $other) {
						$switched = $other;
						$y++;
					} else {
						$path->addPoint($this->getPoint($x, $y));
						$direction = ($switched == $other) ? self::DIRECTION_LEFT : self::DIRECTION_RIGHT;
					}
					break;
			}
		} while (!($x == $startX && $y == $startY));

		return $path;

	}

	/**
	 * @param int $x
	 * @param int $y
	 * @return PathPoint
	 */
	private function getPoint($x, $y)
	{
		return new PathPoint($x - 1, $y - 1);
	}

}




