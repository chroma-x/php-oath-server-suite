<?php

namespace OathServerSuite\Otp;

use OathServerSuite\Exception\NetworkException;
use OathServerSuite\Exception\ParserException;
use OathServerSuite\Exception\ValidationFailedException;
use Yubikey\Validate;

/**
 * Class Validator
 *
 * @package OathServerSuite\Otp
 */
class Validator
{

	/**
	 * @var string
	 */
	private $yubiCloudClientId;

	/**
	 * @var string
	 */
	private $yubiCloudSecretKey;

	/**
	 * @var string
	 */
	private $otp;

	/**
	 * @var Parser
	 */
	private $otpParser;

	/**
	 * @var bool
	 */
	private $otpValid = false;

	/**
	 * Validator constructor.
	 *
	 * @param $yubiCloudClientId
	 * @param $yubiCloudSecretKey
	 */
	public function __construct($yubiCloudClientId, $yubiCloudSecretKey)
	{
		$this->yubiCloudClientId = $yubiCloudClientId;
		$this->yubiCloudSecretKey = $yubiCloudSecretKey;
	}

	/**
	 * Validates the OTP against the YubiCloud
	 *
	 * If the given OTP is malformed or invalid a ValidationFailedException is thrown. If a publicId is given, it is
	 * checked against the public ID part of the OTP. If they does not match a ValidationFailedException is thrown.
	 * If connecting the YubiCloud webservice fails a NetworkException is thrown.
	 *
	 * @param string $otp
	 * @param string $publicId
	 * @return bool
	 * @throws NetworkException
	 * @throws ValidationFailedException
	 */
	public function validate($otp, $publicId = null)
	{
		$this->otp = $otp;
		$this->otpParser = new Parser();
		try {
			$this->otpParser->parse($this->otp);
		} catch (ParserException $parserException) {
			throw new ValidationFailedException('The given OTP is malformed.', 1, $parserException);
		}
		if (!is_null($publicId) && $this->otpParser->getPublicId() !== $publicId) {
			throw new ValidationFailedException('Public ID mismatch.', 2);
		}
		try {
			$yubicoApi = new Validate($this->yubiCloudSecretKey, $this->yubiCloudClientId);
			$response = $yubicoApi->check($otp);
		} catch (\Exception $exception) {
			throw new NetworkException('YubiCloud webservice access failed.', 0, $exception);
		}
		$this->otpValid = $response->success();
		if (!$this->otpValid) {
			throw new ValidationFailedException('OTP invalid.', 3);
		}
		return $this->otpValid;
	}

	/**
	 * @return Parser
	 */
	public function getOtpParser()
	{
		return $this->otpParser;
	}

	/**
	 * @return boolean
	 */
	public function isOtpValid()
	{
		return $this->otpValid;
	}

	/**
	 * @return string
	 */
	public function getOtp()
	{
		return $this->otp;
	}

}
