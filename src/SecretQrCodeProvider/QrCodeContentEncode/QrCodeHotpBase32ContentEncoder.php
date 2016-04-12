<?php

namespace OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode;

use SKleeschulte\Base32;

/**
 * Class QrCodeHotpBase32ContentEncoder
 *
 * @package OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode
 */
class QrCodeHotpBase32ContentEncoder implements Base\QrCodeContentEncoderInterface
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
		return 'otpauth://hotp/' . $keyName . '?secret=' . $secret;
	}

}
