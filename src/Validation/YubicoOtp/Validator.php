<?php

namespace Markenwerk\OathServerSuite\Validation\YubicoOtp;

use Markenwerk\CommonException\NetworkException\Base\NetworkException;
use Markenwerk\OathServerSuite\Exception\ParserException;
use Yubikey\Validate;

/**
 * Class Validator
 *
 * @package Markenwerk\OathServerSuite\YubicoOtp
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
	 * If connecting the YubiCloud webservice fails a NetworkException is thrown.
	 *
	 * @param string $otp
	 * @param string $publicId
	 * @return bool
	 * @throws NetworkException
	 */
	public function validate($otp, $publicId)
	{
		$this->otpParser = new Parser();
		try {
			$this->otpParser->parse($otp);
		} catch (ParserException $parserException) {
			return false;
		}
		if ($this->otpParser->getPublicId() !== $publicId) {
			return false;
		}
		try {
			$yubicoApi = new Validate($this->yubiCloudSecretKey, $this->yubiCloudClientId);
			$response = $yubicoApi->check($otp);
		} catch (\Exception $exception) {
			throw new NetworkException('YubiCloud webservice access failed.', 0, $exception);
		}
		$this->valid = $response->success();
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
