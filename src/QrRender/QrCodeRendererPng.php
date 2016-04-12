<?php

namespace OathServerSuite\QrRender;

use OathServerSuite\QrEncode\QrCode\QrCode;
use OathServerSuite\QrRender\Exception\IoException;

/**
 * Class QrCodeRendererPng
 *
 * @package OathServerSuite\QrRender
 */
class QrCodeRendererPng implements Base\QrCodeRendererInterface
{

	const MARGIN = 2;

	/**
	 * @param QrCode $qrCode
	 * @param string $filename
	 * @throws IoException
	 */
	public function render(QrCode $qrCode, $filename)
	{
		if (!is_dir(dirname($filename)) || !is_writable(dirname($filename))) {
			throw new IoException('QR code path not writable.');
		}

		// Get basic info
		$width = $qrCode->getWidth();
		$height = $qrCode->getHeight();

		// Calculate params
		$blockSize = ceil(1000 / ($width + 2 * self::MARGIN));
		$symbolWidth = ($width + 2 * self::MARGIN) * $blockSize;
		$symbolHeight = ($height + 2 * self::MARGIN) * $blockSize;

		// Define colors
		$black = new \ImagickPixel('#000000');
		$white = new \ImagickPixel('#ffffff');

		// Prepare canvas
		$canvas = new \Imagick();
		$canvas->newImage($symbolWidth, $symbolHeight, $white, "png");
		$canvas->setImageColorspace(\Imagick::COLORSPACE_RGB);
		$canvas->setImageDepth(8);

		// Draw blocks
		$draw = new \ImagickDraw();
		$draw->setFillColor($black);
		$top = self::MARGIN * $blockSize;
		for ($h = 1; $h <= $height; $h++) {
			$left = self::MARGIN * $blockSize;
			$qrCodePointRow = $qrCode->getRow($h);
			for ($w = 1; $w <= $width; $w++) {
				$qrCodePpoint = $qrCodePointRow->getPoint($w);
				if ($qrCodePpoint->isActive()) {
					$draw->rectangle($left, $top, $left + $blockSize, $top + $blockSize);
				}
				$left += $blockSize;
			}
			$top += $blockSize;
		}
		$canvas->drawImage($draw);

		// Write out the image
		$canvas->writeImage($filename);
		$canvas->clear();
		$canvas->destroy();
	}

}
