<?php

namespace ChromaX\OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

/**
 * Class HotpSharedSecretUrlEncoder
 *
 * @package ChromaX\OathServerSuite\SharedSecretUrlEncoder
 */
class HotpSharedSecretUrlEncoder implements Base\SharedSecretUrlEncoderInterface
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
		$encoded = 'otpauth://hotp/' . rawurlencode($keyName) . '?secret=' . $sharedSecret;
		if (!is_null($issuer)) {
			$encoded .= '&issuer=' . rawurlencode($issuer);
		}
		return $encoded;
	}

}
