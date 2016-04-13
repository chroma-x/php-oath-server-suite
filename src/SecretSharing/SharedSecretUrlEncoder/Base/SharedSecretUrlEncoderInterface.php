<?php

namespace OathServerSuite\SecretSharing\SharedSecretUrlEncoder\Base;

/**
 * Interface SharedSecretUrlEncoderInterface
 *
 * @package OathServerSuite\SharedSecretUrlEncoder\Base
 */
interface SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $secret
	 * @return string
	 */
	public function encode($keyName, $secret);

}
