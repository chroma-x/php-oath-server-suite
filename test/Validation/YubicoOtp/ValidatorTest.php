<?php

namespace OathServerSuite\Validation\YubicoOtp;

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
		$validator = new Validator('clientId', 'secretKey');
		// Malformed
		$isValid = $validator->validate('', self::PUBLIC_ID);
		$this->assertEquals(false, $isValid);
		$isValid = $validator->validate('12345678', self::PUBLIC_ID);
		$this->assertEquals(false, $isValid);
		// Wellformed
		$isValid = $validator->validate('ccccccfcttfikkgitudletutjneikkrfcugnuhikdbhj', self::PUBLIC_ID);
		$this->assertEquals(false, $isValid);
	}

}
