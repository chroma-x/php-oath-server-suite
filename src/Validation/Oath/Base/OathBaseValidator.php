<?php

namespace Markenwerk\OathServerSuite\Validation\Oath\Base;

/**
 * Class OathValidator
 *
 * @package Markenwerk\OathServerSuite\Validation\Oath\Base
 */
abstract class OathBaseValidator
{

	/**
	 * The numbers of digits the one time passwords have
	 *
	 * @var int
	 */
	protected $passwordLength;

	/**
	 * @return int
	 */
	public function getPasswordLength()
	{
		return $this->passwordLength;
	}

	/**
	 * @param string $sharedSecret
	 * @param int $counter
	 * @return string
	 */
	protected function calculateValidHotp($sharedSecret, $counter)
	{
		$hmacHash = $this->hashHmac($sharedSecret, $counter);
		$hmacHashTruncated = $this->truncateHash($hmacHash, $this->passwordLength);
		return str_pad($hmacHashTruncated, $this->passwordLength, '0', STR_PAD_LEFT);
	}

	/**
	 * @param string $secret
	 * @param int $counter
	 * @return string
	 */
	private function hashHmac($secret, $counter)
	{
		$binCounter = pack('N*', 0) . pack('N*', $counter);
		$hash = hash_hmac('sha1', $binCounter, $secret, true);
		return $hash;
	}

	/**
	 * @param string $hash
	 * @param int $length
	 * @return int
	 */
	private static function truncateHash($hash, $length = 6)
	{
		$offset = ord($hash[19]) & 0xf;
		return
			(
				((ord($hash[$offset + 0]) & 0x7f) << 24) |
				((ord($hash[$offset + 1]) & 0xff) << 16) |
				((ord($hash[$offset + 2]) & 0xff) << 8) |
				(ord($hash[$offset + 3]) & 0xff)
			) % pow(10, $length);
	}

}
