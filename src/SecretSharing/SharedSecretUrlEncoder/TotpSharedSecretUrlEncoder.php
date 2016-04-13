<?php

namespace OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

/**
 * Class TotpSharedSecretUrlEncoder
 *
 * @package OathServerSuite\SharedSecretUrlEncoder
 */
class TotpSharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret)
	{
		$secret = bin2hex($secret);
		return 'otpauth://totp/' . rawurlencode($keyName) . '?secret=' . $secret;
	}

}
