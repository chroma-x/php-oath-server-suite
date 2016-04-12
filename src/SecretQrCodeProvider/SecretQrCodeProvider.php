<?php

namespace OathServerSuite\SecretQrCodeProvider;

use QrCodeSuite\QrEncode\QrEncoder;
use QrCodeSuite\QrRender\QrCodeRendererPng;
use OathServerSuite\SecretQrCodeProvider\QrCodeContentEncode\Base\QrCodeContentEncoderInterface;

/**
 * Class SecretQrCodeProvider
 *
 * @package OathServerSuite\Totp
 */
class SecretQrCodeProvider
{

	/**
	 * @var QrCodeContentEncoderInterface
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
	 * SecretQrCodeProvider constructor.
	 *
	 * @param QrCodeContentEncoderInterface $contentEncoder
	 * @param string $keyName
	 * @param string $secret
	 */
	public function __construct(QrCodeContentEncoderInterface $contentEncoder, $keyName, $secret)
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
		$qrCodeContents = $this->contentEncoder->encode($this->keyName, $this->secret);
		$qrCode = $this->qrEncoder->encodeQrCode($qrCodeContents);
		$qrRenderer = new QrCodeRendererPng();
		$qrRenderer->render($qrCode, $path);
		return $this;
	}

	/**
	 * @return QrEncoder
	 */
	public function getQrEncoder()
	{
		return $this->qrEncoder;
	}

}
