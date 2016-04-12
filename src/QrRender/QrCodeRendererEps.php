<?php

namespace OathServerSuite\QrRender;

use OathServerSuite\QrEncode\QrCode\QrCode;
use OathServerSuite\QrRender\Exception\IoException;
use OathServerSuite\QrRender\PathFinder\PathPoint;
use OathServerSuite\QrRender\PathFinder\QrCodePathFinder;

/**
 * Class QrCodeRendererEps
 *
 * @package OathServerSuite\QrRender
 */
class QrCodeRendererEps implements Base\QrCodeRendererInterface
{

	const MARGIN = 2;
	const POINTS_PER_BLOCK = 5;

	/**
	 * @var int
	 */
	private $epsHeight;

	/**
	 * @param QrCode $qrCode
	 * @param string $filename
	 */
	public function render(QrCode $qrCode, $filename)
	{
		if (!is_dir(dirname($filename)) || !is_writable(dirname($filename))) {
			throw new IoException('QR code path not writable.');
		}

		$pathFinder = new QrCodePathFinder();
		$paths = $pathFinder->perform($qrCode);

		$epsSource = array();
		$width = $qrCode->getWidth();
		$height = $qrCode->getHeight();

		$epsWidth = self::POINTS_PER_BLOCK * ($width + 2 * self::MARGIN);
		$epsHeight = self::POINTS_PER_BLOCK * ($height + 2 * self::MARGIN);
		$this->epsHeight = $epsHeight;

		$epsSource[] = '%!PS-Adobe-2.0 EPSF-2.0';
		$epsSource[] = '%%BoundingBox: 0 0 ' . ceil($epsWidth) . ' ' . ceil($epsHeight) . '';
		$epsSource[] = '%%HiResBoundingBox: 0 0 ' . $epsWidth . ' ' . $epsHeight . '';
		$epsSource[] = '%%Creator: tk | markenwerk';
		$epsSource[] = '%%CreationDate: ' . time();
		$epsSource[] = '%%DocumentData: Clean7Bit';
		$epsSource[] = '%%LanguageLevel: 2';
		$epsSource[] = '%%Pages: 1';
		$epsSource[] = '%%EndComments';
		$epsSource[] = '%%Page: 1 1';
		$epsSource[] = '/m/moveto load def';
		$epsSource[] = '/l/lineto load def';
		$epsSource[] = '0 0 0 1 setcmykcolor';

		foreach ($paths as $path) {
			for ($i = 0; $i < $path->countPoints(); $i++) {
				if ($i == 0) {
					$epsSource[] = $this->convertPoint($path->getFirstPoint()) . ' m';
				} else {
					$epsSource[] = $this->convertPoint($path->getPoint($i)) . ' l';
				}
			}
			$epsSource[] = 'closepath';
		}

		$epsSource[] = 'eofill';
		$epsSource[] = '%%EOF';

		file_put_contents($filename, implode("\n", $epsSource));
	}

	/**
	 * @param PathPoint $point
	 * @return string
	 */
	private function convertPoint(PathPoint $point)
	{
		$x = self::POINTS_PER_BLOCK * ($point->getX() + self::MARGIN);
		$y = $this->epsHeight - self::POINTS_PER_BLOCK * ($point->getY() + self::MARGIN);
		return $x . ' ' . $y . ' ';
	}

}
