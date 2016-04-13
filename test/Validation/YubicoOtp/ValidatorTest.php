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

	public function testValidateMalformed()
	{
		$this->setExpectedException(get_class(new ValidationFailedException()));
		$validator = new Validator('clientId', 'secretKey');
		$validator->validate('');
		$validator->validate('12345678');
	}

	public function testValidateWellformed()
	{
		$this->setExpectedException(get_class(new ValidationFailedException()));
		$validator = new Validator('clientId', 'secretKey');
		$validator->validate('ccccccfcttfikkgitudletutjneikkrfcugnuhikdbhj');
	}

}
