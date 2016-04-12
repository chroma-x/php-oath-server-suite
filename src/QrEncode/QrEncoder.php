<?php

namespace OathServerSuite\QrEncode;

use OathServerSuite\QrEncode\Exception\QrEncoderException;
use OathServerSuite\QrEncode\QrCode\QrCode;
use OathServerSuite\QrEncode\QrCode\QrCodePointRow;
use OathServerSuite\QrEncode\QrCode\QrCodePoint;

/**
 * Class QrEncoder
 *
 * @package OathServerSuite\QrEncode
 */
class QrEncoder
{

	const QR_CODE_LEVEL_LOW = 'L';
	const QR_CODE_LEVEL_MEDIUM = 'M';
	const QR_CODE_LEVEL_QUALITY = 'Q';
	const QR_CODE_LEVEL_HIGH = 'H';

	/**
	 * @var string
	 */
	private $tempDir = '/tmp/';

	/**
	 * @var string
	 */
	private $level;

	/**
	 * QrEncoder constructor.
	 *
	 * @param string $level
	 */
	public function __construct($level = self::QR_CODE_LEVEL_MEDIUM)
	{
		$this->level = $level;
	}

	/**
	 * @return string
	 */
	public function getTempDir()
	{
		return $this->tempDir;
	}

	/**
	 * @param string $tempDir
	 * @return $this
	 */
	public function setTempDir($tempDir)
	{
		$this->tempDir = $tempDir;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * @param string $level
	 * @return $this
	 */
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}

	/**
	 * @param string $contents
	 * @return QrCode
	 * @throws QrEncoderException
	 */
	public function encodeQrCode($contents)
	{
		$chars = str_split($contents);
		foreach ($chars as $char) {
			if (0 == ord($char)) {
				throw new QrEncoderException('Encoding null character failed');
			}
		}
		// Build temp name
		$pngPath = rtrim($this->tempDir, '/') . '/qr_' . time() . rand(1000, 9999) . '.png';
		// Build command
		$command = array();
		$command[] = 'qrencode -s 1 -m 1';
		if (isset($this->level)) {
			$command[] = '-l';
			$command[] = $this->level;
		}
		$command[] = '-o';
		$command[] = $pngPath;

		// Run command
		$descriptorSpecs = array(
			array('pipe', 'r'),
			array('pipe', 'w'),
			array('pipe', 'w')
		);
		$process = proc_open(implode(' ', $command), $descriptorSpecs, $pipes);
		if (is_resource($process)) {
			fwrite($pipes[0], $contents);
			fclose($pipes[0]);
			$err = stream_get_contents($pipes[2]);
			fclose($pipes[2]);
			proc_close($process);
			if ($this->startsWith($err, "Failed to encode the input data")) {
				throw new QrEncoderException('Too much content');
			}
		} else {
			throw new QrEncoderException('QR encoder internal error');
		}
		$image = imagecreatefrompng($pngPath);
		if (!isset($image)) {
			throw new QrEncoderException('GD lib internal error');
		}
		// Delete file created by qrencode
		unlink($pngPath);

		// Analyse result
		$width = imagesx($image);
		$height = imagesy($image);
		$qrCode = new QrCode($width - 2, $height - 2);
		for ($i = 0; $i < $height; $i++) {
			$qrCodePointRow = new QrCodePointRow();
			for ($w = 0; $w < $width; $w++) {
				$qrCodePointRow->addPoint(new QrCodePoint((bool)imagecolorat($image, $w, $i) == 0));
			}
			$qrCode->addRow($qrCodePointRow);
		}

		return $qrCode;
	}

	/**
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	private function startsWith($haystack, $needle)
	{
		return mb_strpos($haystack, $needle) === 0;
	}

}
