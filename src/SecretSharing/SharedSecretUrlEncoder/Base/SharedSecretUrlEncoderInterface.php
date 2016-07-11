<?php

namespace Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\Base;

/**
 * Interface SharedSecretUrlEncoderInterface
 *
 * @package Markenwerk\OathServerSuite\SharedSecretUrlEncoder\Base
 */
interface SharedSecretUrlEncoderInterface
{

	/**
	 * @param string $keyName
	 * @param string $sharedSecret
	 * @return string
	 */
	public function encode($keyName, $sharedSecret);

}
