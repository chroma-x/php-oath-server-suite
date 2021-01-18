<?php

namespace ChromaX\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\Base;

/**
 * Interface SharedSecretUrlEncoderInterface
 *
 * @package ChromaX\OathServerSuite\SharedSecretUrlEncoder\Base
 */
interface SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $sharedSecret
	 * @param string $issuer
	 * @return string
	 */
	public function encode($keyName, $sharedSecret, $issuer=null);

}
