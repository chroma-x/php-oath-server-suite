<?php

namespace OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode;

/**
 * Class QrCodeHotpContentEncoder
 *
 * @package OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode
 */
class QrCodeHotpContentEncoder implements Base\QrCodeContentEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret)
	{
		$secret = bin2hex($secret);
		return 'otpauth://hotp/' . $keyName . '?secret=' . $secret;
	}

}
