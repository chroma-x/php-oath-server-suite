<?php

namespace Markenwerk\OathServerSuite\Validation\Oath;

/**
 * Class TotpValidator
 *
 * @package Markenwerk\OathServerSuite\Validation\Oath
 */
class TotpValidator extends Base\OathBaseValidator
{

	/**
	 * @var bool
	 */
	private $valid = false;

	/**
	 * The valid period of time in that the one time password has to be validated in seconds
	 *
	 * @var int
	 */
	private $validPeriod;

	/**
	 * TotpValidator constructor.
	 *
	 * @param int $passwordLength
	 * @param int $validPeriod
	 */
	public function __construct($passwordLength = 6, $validPeriod = 30)
	{
		$this->validPeriod = $validPeriod;
		$this->passwordLength = $passwordLength;
	}

	/**
	 * @return int
	 */
	public function getValidPeriod()
	{
		return $this->validPeriod;
	}

	/**
	 * Validates the TOTP
	 *
	 * @param string $totp
	 * @param string $sharedSecret
	 * @return bool
	 */
	public function validate($totp, $sharedSecret)
	{
		$sharedSecret = bin2hex($sharedSecret);
		$validTotp = $this->calculateValidTotp($sharedSecret);
		$this->valid = ($totp === $validTotp);
		return $this->valid;
	}

	/**
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->valid;
	}

	/**
	 * @param string $sharedSecret
	 * @return string
	 */
	private function calculateValidTotp($sharedSecret)
	{
		$counter = $this->getTimeCounter();
		return $this->calculateValidHotp($sharedSecret, $counter);
	}

	/**
	 * @return int
	 */
	private function getTimeCounter()
	{
		return floor(time() / $this->validPeriod);
	}

}
