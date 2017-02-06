<?php

namespace Markenwerk\OathServerSuite\SecretSharing\SharedSecretQrCodeProvider;

use Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\HotpBase32SharedSecretUrlEncoder;
use Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\HotpSharedSecretUrlEncoder;
use Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\TotpBase32SharedSecretUrlEncoder;
use Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\TotpSharedSecretUrlEncoder;
use Markenwerk\QrCodeSuite\QrEncode\QrEncoder;

/**
 * Class SharedSecretQrCodeProviderTest
 *
 * @package Markenwerk\OathServerSuite\SecretSharing\SharedSecretQrCodeProvider
 */
class SharedSecretQrCodeProviderTest extends \PHPUnit_Framework_TestCase
{

	const SHARED_SECRET = '9nxnvWgVw5Ca2YLUIkou2CkV2K15QI';
	const EXPECTED_HOTP_BASE32_SHARED_SECRET_URL = 'otpauth://hotp/Awesome%20Application?secret=GM4TMZJXHA3GKNZWGU3TMNZVGY3TOMZVGQZTMMJTGI2TSNDDGU2TIOJWMI3GMNZVGMZDIMZWMI2TMMZSGRRDGMJTGU2TCNBZ&issuer=Markenwerk';
	const EXPECTED_TOTP_BASE32_SHARED_SECRET_URL = 'otpauth://totp/Awesome%20Application?secret=GM4TMZJXHA3GKNZWGU3TMNZVGY3TOMZVGQZTMMJTGI2TSNDDGU2TIOJWMI3GMNZVGMZDIMZWMI2TMMZSGRRDGMJTGU2TCNBZ&issuer=Markenwerk';
	const EXPECTED_HOTP_SHARED_SECRET_URL = 'otpauth://hotp/Awesome%20Application?secret=396e786e765767567735436132594c55496b6f7532436b56324b31355149&issuer=Markenwerk';
	const EXPECTED_TOTP_SHARED_SECRET_URL = 'otpauth://totp/Awesome%20Application?secret=396e786e765767567735436132594c55496b6f7532436b56324b31355149&issuer=Markenwerk';

	public function testHotpBase32ProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new HotpBase32SharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET, 'Markenwerk');
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-hotp-base32.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code measurements
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getWidth());
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getHeight());
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRows()));
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRow(0)->getPoints()));

		// Test QR code output file mesaurement
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getWidth(), $imageSize[0]);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getHeight(), $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_HOTP_BASE32_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

	public function testTotpBase32ProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new TotpBase32SharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET, 'Markenwerk');
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-totp-base32.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code measurements
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getWidth());
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getHeight());
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRows()));
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRow(0)->getPoints()));

		// Test QR code output file mesaurement
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getWidth(), $imageSize[0]);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getHeight(), $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_TOTP_BASE32_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

	public function testHotpProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new HotpSharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET, 'Markenwerk');
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-hotp.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code measurements
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getWidth());
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getHeight());
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRows()));
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRow(0)->getPoints()));

		// Test QR code output file mesaurement
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getWidth(), $imageSize[0]);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getHeight(), $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_HOTP_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

	public function testTotpProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new TotpSharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET, 'Markenwerk');
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-totp.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code measurements
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getWidth());
		$this->assertEquals(41, $sharedSecretQrCodeProvider->getQrCode()->getHeight());
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRows()));
		$this->assertEquals(43, count($sharedSecretQrCodeProvider->getQrCode()->getRow(0)->getPoints()));

		// Test QR code output file mesaurement
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getWidth(), $imageSize[0]);
		$this->assertEquals($sharedSecretQrCodeProvider->getQrRenderer()->getHeight(), $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_TOTP_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

}
