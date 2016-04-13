<?php

namespace OathServerSuite\SecretSharing\SharedSecretQrCodeProvider;

use OathServerSuite\SecretSharing\SharedSecretUrlEncoder\HotpBase32SharedSecretUrlEncoder;
use OathServerSuite\SecretSharing\SharedSecretUrlEncoder\HotpSharedSecretUrlEncoder;
use OathServerSuite\SecretSharing\SharedSecretUrlEncoder\TotpBase32SharedSecretUrlEncoder;
use OathServerSuite\SecretSharing\SharedSecretUrlEncoder\TotpSharedSecretUrlEncoder;
use QrCodeSuite\QrEncode\QrEncoder;
use QrCodeSuite\QrRender\QrCodeRendererPng;

/**
 * Class SharedSecretQrCodeProviderTest
 *
 * @package OathServerSuite\SecretSharing\SharedSecretQrCodeProvider
 */
class SharedSecretQrCodeProviderTest extends \PHPUnit_Framework_TestCase
{

	const SHARED_SECRET ='9nxnvWgVw5Ca2YLUIkou2CkV2K15QI';
	const EXPECTED_HOTP_BASE32_SHARED_SECRET_URL = 'otpauth://hotp/Awesome%20Application?secret=GM4TMZJXHA3GKNZWGU3TMNZVGY3TOMZVGQZTMMJTGI2TSNDDGU2TIOJWMI3GMNZVGMZDIMZWMI2TMMZSGRRDGMJTGU2TCNBZ';
	const EXPECTED_TOTP_BASE32_SHARED_SECRET_URL = 'otpauth://totp/Awesome%20Application?secret=GM4TMZJXHA3GKNZWGU3TMNZVGY3TOMZVGQZTMMJTGI2TSNDDGU2TIOJWMI3GMNZVGMZDIMZWMI2TMMZSGRRDGMJTGU2TCNBZ';
	const EXPECTED_HOTP_SHARED_SECRET_URL = 'otpauth://hotp/Awesome%20Application?secret=396e786e765767567735436132594c55496b6f7532436b56324b31355149';
	const EXPECTED_TOTP_SHARED_SECRET_URL = 'otpauth://totp/Awesome%20Application?secret=396e786e765767567735436132594c55496b6f7532436b56324b31355149';

	public function testHotpBase32ProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new HotpBase32SharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET);
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-hotp-base32.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code output file mesaurement
		$blockSize = ceil(1000 / ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN));
		$symbolWidth = ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$symbolHeight = ($sharedSecretQrCodeProvider->getQrCode()->getHeight() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($symbolWidth, $imageSize[0]);
		$this->assertEquals($symbolHeight, $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_HOTP_BASE32_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

	public function testTotpBase32ProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new TotpBase32SharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET);
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-totp-base32.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code output file mesaurement
		$blockSize = ceil(1000 / ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN));
		$symbolWidth = ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$symbolHeight = ($sharedSecretQrCodeProvider->getQrCode()->getHeight() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($symbolWidth, $imageSize[0]);
		$this->assertEquals($symbolHeight, $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_TOTP_BASE32_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

	public function testHotpProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new HotpSharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET);
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-hotp.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code output file mesaurement
		$blockSize = ceil(1000 / ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN));
		$symbolWidth = ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$symbolHeight = ($sharedSecretQrCodeProvider->getQrCode()->getHeight() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($symbolWidth, $imageSize[0]);
		$this->assertEquals($symbolHeight, $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_HOTP_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

	public function testTotpProvideQrCode()
	{
		// Init QR code renderer
		$sharedSecretQrCodeProvider = new SharedSecretQrCodeProvider(new TotpSharedSecretUrlEncoder(), 'Awesome Application', self::SHARED_SECRET);
		$sharedSecretQrCodeProvider->getQrEncoder()
			->setLevel(QrEncoder::QR_CODE_LEVEL_LOW)
			->setTempDir(__DIR__ . '/tmp/');
		$qrCodeOutputPath = __DIR__ . '/tmp/test-totp.png';
		$sharedSecretQrCodeProvider->provideQrCode($qrCodeOutputPath);

		// Test QR code output file exists
		$this->assertFileExists($qrCodeOutputPath);

		// Test QR code output file mesaurement
		$blockSize = ceil(1000 / ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN));
		$symbolWidth = ($sharedSecretQrCodeProvider->getQrCode()->getWidth() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$symbolHeight = ($sharedSecretQrCodeProvider->getQrCode()->getHeight() + 2 * QrCodeRendererPng::MARGIN) * $blockSize;
		$imageSize = getimagesize($qrCodeOutputPath);
		$this->assertEquals($symbolWidth, $imageSize[0]);
		$this->assertEquals($symbolHeight, $imageSize[1]);

		// Remove test QR code output file
		unlink($qrCodeOutputPath);

		// Test QR code contents
		$this->assertEquals(self::EXPECTED_TOTP_SHARED_SECRET_URL, $sharedSecretQrCodeProvider->getQrCodeContents());
	}

}
