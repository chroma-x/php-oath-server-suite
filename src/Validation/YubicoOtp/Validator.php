<?php

namespace OathServerSuite\Validation\YubicoOtp;

use OathServerSuite\Exception\NetworkException;
use OathServerSuite\Exception\ParserException;
use OathServerSuite\Exception\ValidationFailedException;
use Yubikey\Validate;

/**
 * Class Validator
 *
 * @package OathServerSuite\YubicoOtp
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
	 * @var Parser
	 */
	private $otpParser;

	/**
	 * @var bool
	 */
	private $valid = false;

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
	 * If the given OTP is malformed or invalid a ValidationFailedException is thrown.
	 * If connecting the YubiCloud webservice fails a NetworkException is thrown.
	 *
	 * @param string $otp
	 * @param string $publicId
	 * @return bool
	 * @throws NetworkException
	 * @throws ValidationFailedException
	 */
	public function validate($otp, $publicId)
	{
		$this->otpParser = new Parser();
		try {
			$this->otpParser->parse($otp);
		} catch (ParserException $parserException) {
			throw new ValidationFailedException('The given OTP is malformed.', 1, $parserException);
		}
		if ($this->otpParser->getPublicId() !== $publicId) {
			throw new ValidationFailedException('Public ID mismatch.', 2);
		}
		try {
			$yubicoApi = new Validate($this->yubiCloudSecretKey, $this->yubiCloudClientId);
			$response = $yubicoApi->check($otp);
		} catch (\Exception $exception) {
			throw new NetworkException('YubiCloud webservice access failed.', 0, $exception);
		}
		$this->valid = $response->success();
		if (!$this->valid) {
			throw new ValidationFailedException('OTP invalid.', 3);
		}
		return $this->valid;
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
	public function isValid()
	{
		return $this->valid;
	}

}
