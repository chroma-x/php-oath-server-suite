<?php

namespace OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode;

/**
 * Class QrCodeTotpContentEncoder
 *
 * @package OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode
 */
class QrCodeTotpContentEncoder implements Base\QrCodeContentEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret)
	{
		$secret = bin2hex($secret);
		return 'otpauth://totp/' . $keyName . '?secret=' . $secret;
	}

}
