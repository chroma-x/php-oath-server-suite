<?php

namespace OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode;

use SKleeschulte\Base32;

/**
 * Class QrCodeTotpBase32ContentEncoder
 *
 * @package OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode
 */
class QrCodeTotpBase32ContentEncoder implements Base\QrCodeContentEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret)
	{
		$secret = bin2hex($secret);
		$secret = Base32::encodeByteStr($secret);
		return 'otpauth://totp/' . $keyName . '?secret=' . $secret;
	}

}
