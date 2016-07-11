<?php

namespace Markenwerk\OathServerSuite\Validation\Oath;

/**
 * Class HotpValidator
 *
 * @package Markenwerk\OathServerSuite\Validation\Oath
 */
class HotpValidator extends Base\OathBaseValidator
{

	/**
	 * @var bool
	 */
	private $valid = false;

	/**
	 * TotpValidator constructor.
	 *
	 * @param int $passwordLength
	 */
	public function __construct($passwordLength = 6)
	{
		$this->passwordLength = $passwordLength;
	}

	/**
	 * Validates the TOTP
	 *
	 * @param string $hotp
	 * @param string $sharedSecret
	 * @param int $counter
	 * @return bool
	 */
	public function validate($hotp, $sharedSecret, $counter)
	{
		$sharedSecret = bin2hex($sharedSecret);
		$validHotp = $this->calculateValidHotp($sharedSecret, $counter);
		$this->valid = ($hotp === $validHotp);
		return $this->valid;
	}

	/**
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->valid;
	}

}
