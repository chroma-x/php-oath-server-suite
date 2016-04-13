<?php

namespace OathServerSuite\Validation\YubicoOtp;

use OathServerSuite\Exception\ValidationFailedException;

/**
 * Class ValidatorTest
 *
 * @package OathServerSuite\YubicoOtp
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{

	const PUBLIC_ID = 'ccccccfcttfik';

	public function testValidateMalformed()
	{
		$this->setExpectedException(get_class(new ValidationFailedException()));
		$validator = new Validator('clientId', 'secretKey');
		$validator->validate('', self::PUBLIC_ID);
		$validator->validate('12345678', self::PUBLIC_ID);
	}

	public function testValidateWellformed()
	{
		$this->setExpectedException(get_class(new ValidationFailedException()));
		$validator = new Validator('clientId', 'secretKey');
		$validator->validate('ccccccfcttfikkgitudletutjneikkrfcugnuhikdbhj', self::PUBLIC_ID);
	}

}
