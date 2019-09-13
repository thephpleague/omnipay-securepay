<?php

namespace Omnipay\SecurePay;

use Omnipay\Tests\GatewayTestCase;

class SecureXMLGatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new SecureXMLGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('ABC0001');
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(['amount' => '10.00']);

        $this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLAuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(['amount' => '10.00']);

        $this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLPurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

	public function testPurchaseUsingStoredCard()
	{
		$request = $this->gateway->purchase(['amount' => '10.00', 'cardReference' => 'CRN00110011']);

		$this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLStoredCardPurchaseRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
		$this->assertSame('CRN00110011', $request->getCardReference());
	}

    public function testRefund()
    {
        $request = $this->gateway->refund(['amount' => '10.00', 'transactionId' => 'order12345']);

        $this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLRefundRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('order12345', $request->getTransactionId());
    }

	public function testCreateCard()
	{
		$request = $this->gateway->createCard(['amount' => '0.01', 'cardReference' => 'CRN00110011']);

		$this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLStoreCardRequest', $request);
		$this->assertSame('0.01', $request->getAmount());
		$this->assertSame('CRN00110011', $request->getCardReference());
	}

	public function testUpdateCard()
	{
		$request = $this->gateway->updateCard(['cardReference' => 'CRN00110011']);

		$this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLEditCardRequest', $request);
		$this->assertSame('CRN00110011', $request->getCardReference());
	}

	public function testDeleteCard()
	{
		$request = $this->gateway->deleteCard(['cardReference' => 'CRN00110011']);

		$this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLDeleteCardRequest', $request);
		$this->assertSame('CRN00110011', $request->getCardReference());
	}
}
