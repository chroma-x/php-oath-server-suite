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
	 * @param string $sharedSecret
	 * @return string
	 */
	public function encode($keyName, $sharedSecret)
	{
		$sharedSecret = bin2hex($sharedSecret);
		$sharedSecret = Base32::encodeByteStr($sharedSecret, true);
		return 'otpauth://hotp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
	}

}
