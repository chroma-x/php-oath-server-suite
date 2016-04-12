<?php

namespace OathServerSuite\QrRender;

use OathServerSuite\QrEncode\QrCode\QrCode;
use OathServerSuite\QrRender\Exception\IoException;

/**
 * Class QrCodeRendererTiff
 *
 * @package OathServerSuite\QrRender
 */
class QrCodeRendererTiff implements Base\QrCodeRendererInterface
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
		$black = new \ImagickPixel('cmyk(0,0,0,255)');
		$white = new \ImagickPixel('cmyk(0,0,0,0)');

		// Prepare canvas
		$canvas = new \Imagick();
		$canvas->newImage($symbolWidth, $symbolHeight, $white, "tiff");
		$canvas->setImageColorspace(\Imagick::COLORSPACE_CMYK);
		$canvas->setImageDepth(8);

		// Prepare block
		$block = new \Imagick();
		$block->newImage($blockSize, $blockSize, $black, "tiff");
		$block->setImageColorspace(\Imagick::COLORSPACE_CMYK);
		$block->setImageDepth(8);

		// Draw blocks
		$top = self::MARGIN * $blockSize;
		for ($h = 1; $h <= $height; $h++) {
			$left = self::MARGIN * $blockSize;
			$qrCodePointRow = $qrCode->getRow($h);
			for ($w = 1; $w <= $width; $w++) {
				$qrCodePpoint = $qrCodePointRow->getPoint($w);
				if ($qrCodePpoint->isActive()) {
					$canvas->compositeImage($block, \Imagick::COMPOSITE_ATOP, $left, $top);
				}
				$left += $blockSize;
			}
			$top += $blockSize;
		}

		// Write out the image
		$canvas->writeImage($filename);
		$canvas->clear();
		$canvas->destroy();
		$block->clear();
		$block->destroy();
	}

}
