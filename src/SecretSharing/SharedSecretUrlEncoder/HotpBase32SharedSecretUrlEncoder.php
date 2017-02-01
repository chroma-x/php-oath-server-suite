<?php

namespace Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

use SKleeschulte\Base32;

/**
 * Class HotpBase32SharedSecretUrlEncoder
 *
 * @package Markenwerk\OathServerSuite\SharedSecretUrlEncoder
 */
class HotpBase32SharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $sharedSecret
	 * @param string $issuer
	 * @return string
	 */
	public function encode($keyName, $sharedSecret, $issuer = null)
	{
		$sharedSecret = bin2hex($sharedSecret);
		$sharedSecret = Base32::encodeByteStr($sharedSecret, true);
		$encoded = 'otpauth://hotp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
		if (!is_null($issuer)) {
			$encoded .= '&issuer=' . rawurlencode($issuer);
		}
		return $encoded;
	}

}
