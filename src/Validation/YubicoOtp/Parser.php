<?php

namespace Markenwerk\OathServerSuite\Validation\YubicoOtp;

use Markenwerk\OathServerSuite\Exception\ParserException;

/**
 * Class Parser
 *
 * Based on the official [YubiCloud PHP client](https://github.com/Yubico/yubico-php-client/blob/master/YubiCloud.php)
 *
 * @package Markenwerk\OathServerSuite\YubicoOtp
 */
class Parser
{

	/**
	 * @var string
	 */
	private $otp;

	/**
	 * @var string
	 */
	private $otpEffective;

	/**
	 * @var string
	 */
	private $otpDelimiter = '[:]';

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $publicId;

	/**
	 * @var string
	 */
	private $ciphertext;

	/**
	 * @param string $otp
	 * @throws ParserException
	 * @return void
	 */
	public function parse($otp)
	{
		$this->otp = $otp;
		if (!preg_match("/^((.*)" . $this->getOtpDelimiter() . ")?" .
			"(([cbdefghijklnrtuv]{0,16})" .
			"([cbdefghijklnrtuv]{32}))$/i",
			$this->getOtp(), $matches)
		) {
			/* Dvorak? */
			if (!preg_match("/^((.*)" . $this->getOtpDelimiter() . ")?" .
				"(([jxe\.uidchtnbpygk]{0,16})" .
				"([jxe\.uidchtnbpygk]{32}))$/i",
				$this->getOtp(), $matches)
			) {
				throw new ParserException('OTP not parsable');
			} else {
				$this->otpEffective = strtr($matches[3], "jxe.uidchtnbpygk", "cbdefghijklnrtuv");
			}
		} else {
			$this->otpEffective = $matches[3];
		}
		$this->password = $matches[2];
		$this->publicId = $matches[4];
		$this->ciphertext = $matches[5];
	}

	/**
	 * @return string
	 */
	public function getOtpDelimiter()
	{
		return $this->otpDelimiter;
	}

	/**
	 * @return string
	 */
	public function getOtp()
	{
		return $this->otp;
	}

	/**
	 * @return string
	 */
	public function getOtpEffective()
	{
		return $this->otpEffective;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return string
	 */
	public function getPublicId()
	{
		return $this->publicId;
	}

	/**
	 * @return string
	 */
	public function getCiphertext()
	{
		return $this->ciphertext;
	}

}
