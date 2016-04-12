<?php

namespace OathServerSuite\Otp;

use OathServerSuite\Exception\ParserException;

/**
 * Class OtpParserTest
 *
 * @package OathServerSuite\Otp
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @throws ParserException
	 */
	public function testParse()
	{
		$this->setExpectedException(get_class(new ParserException()));
		$parser = new Parser();
		$parser->parse('');
		$parser->parse('123456789');
	}

}
