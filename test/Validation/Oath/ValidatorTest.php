<?php

namespace Markenwerk\OathServerSuite\Validation\Oath;

/**
 * Class ValidatorTest
 *
 * @package Markenwerk\OathServerSuite\Validation\Oath
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{

	const TOTP = '847755';
	const HOTP = '092615';
	const SHARED_SECRET = '9nxnvWgVw5Ca2YLUIkou2CkV2K15QI';
	const COUNTER = 3;

	public function testValidateTotp()
	{
		$validator = new TotpValidator();
		$isValid = $validator->validate(self::TOTP, self::SHARED_SECRET);
		$this->assertEquals(false, $isValid);
		$this->assertEquals($isValid, $validator->isValid());
		$this->assertEquals(30, $validator->getValidPeriod());
		$this->assertEquals(6, $validator->getPasswordLength());
	}

	public function testValidateHotp()
	{
		$validator = new HotpValidator();
		$isValid = $validator->validate(self::HOTP, self::SHARED_SECRET, self::COUNTER);
		$this->assertEquals(false, $isValid);
		$this->assertEquals($isValid, $validator->isValid());
		$this->assertEquals(6, $validator->getPasswordLength());
	}

}
