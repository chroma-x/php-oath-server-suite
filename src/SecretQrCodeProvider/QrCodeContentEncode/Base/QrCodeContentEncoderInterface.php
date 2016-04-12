<?php

namespace OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode\Base;

/**
 * Interface QrCodeContentEncoderInterface
 *
 * @package OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode\Base
 */
interface QrCodeContentEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret);

}
