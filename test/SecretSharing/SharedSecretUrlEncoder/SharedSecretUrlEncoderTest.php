<?php

namespace OathServerSuite\SecretSharing\SharedSecretUrlEncoder;

/**
 * Class SharedSecretQrCodeProviderTest
 *
 * @package OathServerSuite\SharedSecretQrCodeProvider
 */
class SharedSecretUrlEncoderTest extends \PHPUnit_Framework_TestCase
{

	const SHARED_SECRET ='9nxnvWgVw5Ca2YLUIkou2CkV2K15QI';
	const EXPECTED_HOTP_BASE32_SHARED_SECRET_URL = 'otpauth://hotp/Awesome%20Application?secret=GM4TMZJXHA3GKNZWGU3TMNZVGY3TOMZVGQZTMMJTGI2TSNDDGU2TIOJWMI3GMNZVGMZDIMZWMI2TMMZSGRRDGMJTGU2TCNBZ';
	const EXPECTED_TOTP_BASE32_SHARED_SECRET_URL = 'otpauth://totp/Awesome%20Application?secret=GM4TMZJXHA3GKNZWGU3TMNZVGY3TOMZVGQZTMMJTGI2TSNDDGU2TIOJWMI3GMNZVGMZDIMZWMI2TMMZSGRRDGMJTGU2TCNBZ';
	const EXPECTED_HOTP_SHARED_SECRET_URL = 'otpauth://hotp/Awesome%20Application?secret=396e786e765767567735436132594c55496b6f7532436b56324b31355149';
	const EXPECTED_TOTP_SHARED_SECRET_URL = 'otpauth://totp/Awesome%20Application?secret=396e786e765767567735436132594c55496b6f7532436b56324b31355149';

	public function testHotpBase32UrlEncode()
	{
		$sharedSecretUrlEncoder = new HotpBase32SharedSecretUrlEncoder();
		$sharedSecretUrl = $sharedSecretUrlEncoder->encode('Awesome Application', self::SHARED_SECRET);
		$this->assertEquals(self::EXPECTED_HOTP_BASE32_SHARED_SECRET_URL, $sharedSecretUrl);
	}

	public function testTotpBase32UrlEncode()
	{
		$sharedSecretUrlEncoder = new TotpBase32SharedSecretUrlEncoder();
		$sharedSecretUrl = $sharedSecretUrlEncoder->encode('Awesome Application', self::SHARED_SECRET);
		$this->assertEquals(self::EXPECTED_TOTP_BASE32_SHARED_SECRET_URL, $sharedSecretUrl);
	}

	public function testHotpUrlEncode()
	{
		$sharedSecretUrlEncoder = new HotpSharedSecretUrlEncoder();
		$sharedSecretUrl = $sharedSecretUrlEncoder->encode('Awesome Application', self::SHARED_SECRET);
		$this->assertEquals(self::EXPECTED_HOTP_SHARED_SECRET_URL, $sharedSecretUrl);
	}

	public function testTotpUrlEncode()
	{
		$sharedSecretUrlEncoder = new TotpSharedSecretUrlEncoder();
		$sharedSecretUrl = $sharedSecretUrlEncoder->encode('Awesome Application', self::SHARED_SECRET);
		$this->assertEquals(self::EXPECTED_TOTP_SHARED_SECRET_URL, $sharedSecretUrl);
	}

}
