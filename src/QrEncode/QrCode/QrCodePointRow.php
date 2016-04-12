<?php

namespace OathServerSuite\QrEncode\QrCode;

/**
 * Class QrCodePointRow
 *
 * @package OathServerSuite\QrEncode
 */
class QrCodePointRow
{

	/**
	 * @var QrCodePoint[]
	 */
	private $points;

	/**
	 * @return QrCodePoint[]
	 */
	public function getPoints()
	{
		return $this->points;
	}

	/**
	 * @param int $index
	 * @return QrCodePoint
	 */
	public function getPoint($index)
	{
		if (!isset($this->points[$index])) {
			return null;
		}
		return $this->points[$index];
	}

	/**
	 * @param QrCodePoint[] $points
	 * @return $this
	 */
	public function setPoints($points)
	{
		$this->points = $points;
		return $this;
	}

	/**
	 * @param QrCodePoint $point
	 */
	public function addPoint(QrCodePoint $point)
	{
		$this->points[] = $point;
	}

	/**
	 * @param int $index
	 * @return $this
	 */
	public function removePoint($index)
	{
		if (!isset($this->points[$index])) {
			return $this;
		}
		unset($this->points[$index]);
		return $this;
	}

	/**
	 * @param int $index
	 * @param QrCodePoint $point
	 * @return $this
	 */
	public function replacePoint($index, QrCodePoint $point)
	{
		if (!isset($this->points[$index])) {
			return $this;
		}
		$this->points[$index] = $point;
		return $this;
	}

}
