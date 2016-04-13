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
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret)
	{
		$secret = bin2hex($secret);
		return 'otpauth://hotp/' . rawurlencode($keyName) . '?secret=' . $secret;
	}

}
