<?php

namespace Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

/**
 * Class TotpSharedSecretUrlEncoder
 *
 * @package Markenwerk\OathServerSuite\SharedSecretUrlEncoder
 */
class TotpSharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $sharedSecret
	 * @return string
	 */
	public function encode($keyName, $sharedSecret)
	{
		$sharedSecret = bin2hex($sharedSecret);
		return 'otpauth://totp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
	}

}
