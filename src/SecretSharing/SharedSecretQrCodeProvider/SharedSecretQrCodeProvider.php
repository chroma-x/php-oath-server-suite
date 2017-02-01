<?php

namespace Markenwerk\OathServerSuite\SecretSharing\SharedSecretQrCodeProvider;

use Markenwerk\QrCodeSuite\QrEncode\QrCode\QrCode;
use Markenwerk\QrCodeSuite\QrEncode\QrEncoder;
use Markenwerk\QrCodeSuite\QrRender\QrCodeRendererPng;
use Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\Base\SharedSecretUrlEncoderInterface;

/**
 * Class SharedSecretQrCodeProvider
 *
 * @package Markenwerk\OathServerSuite\SharedSecretQrCodeProvider
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
	 * @var QrCodeRendererPng
	 */
	private $qrRenderer;

	/**
	 * @var string
	 */
	private $qrCodeContents;

	/**
	 * @var QrCode
	 */
	private $qrCode;

	/**
	 * @var string
	 */
	private $issuer;

	/**
	 * SecretQrCodeProvider constructor.
	 *
	 * @param SharedSecretUrlEncoderInterface $contentEncoder
	 * @param string $keyName
	 * @param string $secret
	 * @param string $issuer
	 */
	public function __construct(SharedSecretUrlEncoderInterface $contentEncoder, $keyName, $secret, $issuer = null)
	{
		$this->contentEncoder = $contentEncoder;
		$this->keyName = $keyName;
		$this->secret = $secret;
		$this->issuer = $issuer;
		$this->qrEncoder = new QrEncoder();
	}

	/**
	 * @param string $path
	 * @return $this
	 */
	public function provideQrCode($path)
	{
		$this->qrCodeContents = $this->contentEncoder->encode($this->keyName, $this->secret, $this->issuer);
		$this->qrCode = $this->qrEncoder->encodeQrCode($this->qrCodeContents);
		$this->qrRenderer = new QrCodeRendererPng();
		$this->qrRenderer->render($this->qrCode, $path);
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
	 * @return QrCodeRendererPng
	 */
	public function getQrRenderer()
	{
		return $this->qrRenderer;
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
