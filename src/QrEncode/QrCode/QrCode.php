<?php

namespace OathServerSuite\QrEncode\QrCode;

/**
 * Class QrCode
 *
 * @package OathServerSuite\QrEncode
 */
class QrCode
{

	/**
	 * @var int
	 */
	private $width;

	/**
	 * @var int
	 */
	private $height;

	/**
	 * @var QrCodePointRow[]
	 */
	private $rows;

	/**
	 * QrCode constructor.
	 *
	 * @param int $width
	 * @param int $height
	 * @param array $rows
	 */
	public function __construct($width, $height, array $rows = null)
	{
		$this->width = $width;
		$this->height = $height;
		$this->rows = $rows;
	}

	/**
	 * @return int
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param int $width
	 * @return $this
	 */
	public function setWidth($width)
	{
		$this->width = $width;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * @param int $height
	 * @return $this
	 */
	public function setHeight($height)
	{
		$this->height = $height;
		return $this;
	}

	/**
	 * @return QrCodePointRow[]
	 */
	public function getRows()
	{
		return $this->rows;
	}

	/**
	 * @param int $index
	 * @return QrCodePointRow
	 */
	public function getRow($index)
	{
		if (!isset($this->rows[$index])) {
			return null;
		}
		return $this->rows[$index];
	}

	/**
	 * @param QrCodePointRow[] $rows
	 * @return $this
	 */
	public function setRows($rows)
	{
		$this->rows = $rows;
		return $this;
	}

	/**
	 * @param QrCodePointRow $row
	 * @return $this
	 */
	public function addRow(QrCodePointRow $row)
	{
		$this->rows[] = $row;
		return $this;
	}

	/**
	 * @param int $index
	 * @return $this
	 */
	public function removeRow($index)
	{
		if (!isset($this->rows[$index])) {
			return $this;
		}
		unset($this->rows[$index]);
		return $this;
	}

	/**
	 * @param int $index
	 * @param QrCodePointRow $row
	 * @return $this
	 */
	public function replaceRow($index, QrCodePointRow $row)
	{
		if (!isset($this->rows[$index])) {
			return $this;
		}
		$this->rows[$index] = $row;
		return $this;
	}

}
