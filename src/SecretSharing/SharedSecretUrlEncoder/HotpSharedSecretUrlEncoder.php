<?php

namespace OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

/**
 * Class HotpSharedSecretUrlEncoder
 *
 * @package OathServerSuite\SharedSecretUrlEncoder
 */
class HotpSharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $sharedSecret
	 * @return string
	 */
	public function encode($keyName, $sharedSecret)
	{
		$sharedSecret = bin2hex($sharedSecret);
		return 'otpauth://hotp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
	}

}
