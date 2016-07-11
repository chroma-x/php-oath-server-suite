<?php

namespace Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

use SKleeschulte\Base32;

/**
 * Class TotpBase32SharedSecretUrlEncoder
 *
 * @package Markenwerk\OathServerSuite\SharedSecretUrlEncoder
 */
class TotpBase32SharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $sharedSecret
	 * @return string
	 */
	public function encode($keyName, $sharedSecret)
	{
		$sharedSecret = bin2hex($sharedSecret);
		$sharedSecret = Base32::encodeByteStr($sharedSecret, true);
		return 'otpauth://totp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
	}

}
