<?php

namespace ChromaX\OathServerSuite\Validation\YubicoOtp;

/**
 * Class ValidatorTest
 *
 * @package ChromaX\OathServerSuite\Validation\YubicoOtp
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{

	const PUBLIC_ID = 'ccccccfcttfi';

	public function testValidateMalformed()
	{
		$validator = new Validator('clientId', 'secretKey');
		// Malformed
		$isValid = $validator->validate('', self::PUBLIC_ID);
		$this->assertEquals(false, $isValid);
		$isValid = $validator->validate('12345678', self::PUBLIC_ID);
		$this->assertEquals(false, $isValid);
		// Malformed
		$validator->validate('ccccccfcttfikkgitudletutjneikkrfcugnuhikdbhj', 'abc');
		$this->assertEquals(false, $validator->isValid());
		// Wellformed
		$validator->validate('ccccccfcttfikkgitudletutjneikkrfcugnuhikdbhj', self::PUBLIC_ID);
		$this->assertEquals(false, $validator->isValid());
		// Parser
		$parser = $validator->getOtpParser();
		$this->assertInstanceOf('\ChromaX\OathServerSuite\Validation\YubicoOtp\Parser', $parser);
	}

}
