<?php

namespace OathServerSuite\QrRender\Base;

use OathServerSuite\QrEncode\QrCode\QrCode;

/**
 * Interface QrCodeRendererInterface
 *
 * @package OathServerSuite\QrRender\Base
 */
interface QrCodeRendererInterface
{

	/**
	 * @param QrCode $qrCode
	 * @param $filename
	 * @return void
	 */
	public function render(QrCode $qrCode, $filename);

}
