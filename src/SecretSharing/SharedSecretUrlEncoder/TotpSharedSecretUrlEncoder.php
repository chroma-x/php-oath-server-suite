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
	 * @param string $issuer
	 * @return string
	 */
	public function encode($keyName, $sharedSecret, $issuer = null)
	{
		$sharedSecret = bin2hex($sharedSecret);
		$encoded = 'otpauth://totp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
		if (!is_null($issuer)) {
			$encoded .= '&issuer=' . rawurlencode($issuer);
		}
		return $encoded;
	}

}
