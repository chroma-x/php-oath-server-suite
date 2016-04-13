<?php

namespace OathServerSuite\Validation\YubicoOtp;

use OathServerSuite\Exception\ParserException;

/**
 * Class ParserTest
 *
 * @package OathServerSuite\Validation\YubicoOtp
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
