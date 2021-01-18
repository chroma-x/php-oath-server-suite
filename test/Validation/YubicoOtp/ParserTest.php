<?php

namespace ChromaX\OathServerSuite\Validation\YubicoOtp;

use ChromaX\OathServerSuite\Exception\ParserException;

/**
 * Class ParserTest
 *
 * @package ChromaX\OathServerSuite\Validation\YubicoOtp
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{

	const OTP = 'ccccccfcttfikkgitudletutjneikkrfcugnuhikdbhj';

	/**
	 * @throws ParserException
	 */
	public function testParseInvalid()
	{
		$this->setExpectedException(get_class(new ParserException()));
		$parser = new Parser();
		$parser->parse('');
		$parser->parse('123456789');
	}

	/**
	 * @throws ParserException
	 */
	public function testParseValid()
	{
		$parser = new Parser();
		$parser->parse(self::OTP);
		$this->assertEquals(self::OTP, $parser->getOtpEffective());
		$this->assertEmpty($parser->getPassword());
		$this->assertEquals('kkgitudletutjneikkrfcugnuhikdbhj', $parser->getCiphertext());
	}

}
