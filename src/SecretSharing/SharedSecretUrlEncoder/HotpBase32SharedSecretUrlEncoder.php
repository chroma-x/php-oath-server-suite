<?php

namespace OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

use SKleeschulte\Base32;

/**
 * Class HotpBase32SharedSecretUrlEncoder
 *
 * @package OathServerSuite\SharedSecretUrlEncoder
 */
class HotpBase32SharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
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
		return 'otpauth://hotp/' . rawurlencode($keyName) . '?secret=' . $secret;
	}

}
