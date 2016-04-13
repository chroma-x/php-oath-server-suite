<?php

namespace OathServerSuite\SecretSharing\SharedSecretQrCodeProvider;

use QrCodeSuite\QrEncode\QrCode\QrCode;
use QrCodeSuite\QrEncode\QrEncoder;
use QrCodeSuite\QrRender\QrCodeRendererPng;
use OathServerSuite\SecretSharing\SharedSecretUrlEncoder\Base\SharedSecretUrlEncoderInterface;

/**
 * Class SharedSecretQrCodeProvider
 *
 * @package OathServerSuite\SharedSecretQrCodeProvider
 */
class SharedSecretQrCodeProvider
{

	/**
	 * @var SharedSecretUrlEncoderInterface
	 */
	private $contentEncoder;

	/**
	 * @var string
	 */
	private $keyName;

	/**
	 * @var string
	 */
	private $secret;

	/**
	 * @var QrEncoder
	 */
	private $qrEncoder;

	/**
	 * @var string
	 */
	private $qrCodeContents;

	/**
	 * @var QrCode
	 */
	private $qrCode;

	/**
	 * SecretQrCodeProvider constructor.
	 *
	 * @param SharedSecretUrlEncoderInterface $contentEncoder
	 * @param string $keyName
	 * @param string $secret
	 */
	public function __construct(SharedSecretUrlEncoderInterface $contentEncoder, $keyName, $secret)
	{
		$this->contentEncoder = $contentEncoder;
		$this->keyName = $keyName;
		$this->secret = $secret;
		$this->qrEncoder = new QrEncoder();
	}

	/**
	 * @param string $path
	 * @return $this
	 */
	public function provideQrCode($path)
	{
		$this->qrCodeContents = $this->contentEncoder->encode($this->keyName, $this->secret);
		$this->qrCode = $this->qrEncoder->encodeQrCode($this->qrCodeContents);
		$qrRenderer = new QrCodeRendererPng();
		$qrRenderer->render($this->qrCode, $path);
		return $this;
	}

	/**
	 * @return QrEncoder
	 */
	public function getQrEncoder()
	{
		return $this->qrEncoder;
	}

	/**
	 * @return string
	 */
	public function getQrCodeContents()
	{
		return $this->qrCodeContents;
	}

	/**
	 * @return QrCode
	 */
	public function getQrCode()
	{
		return $this->qrCode;
	}

}
