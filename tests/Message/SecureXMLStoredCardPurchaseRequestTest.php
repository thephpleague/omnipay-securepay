<?php

namespace Omnipay\SecurePay\Message;

use Omnipay\Tests\TestCase;

class SecureXMLStoredCardPurchaseRequestTest extends TestCase
{
	public function setUp()
	{
		$this->request = new SecureXMLStoredCardPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

		$this->request->initialize([
			'merchantId' => 'ABC0030',
			'transactionPassword' => 'abc123',
			'amount' => '12.00',
			'transactionId' => '1234',
			'cardReference' => 'CRN00110011',
		]);
	}

	public function testSendSuccess()
	{
		$this->setMockHttpResponse('SecureXMLStoredCardPurchaseRequestSendSuccess.txt');
		$response = $this->request->send();
		$data = $response->getData();

		$this->assertInstanceOf('Omnipay\\SecurePay\\Message\\SecureXMLResponse', $response);;

		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('3', (string) $data->Periodic->PeriodicList->PeriodicItem->txnType); //can't find a reference but seems txntype for stored cards is 3.
		$this->assertSame('009729', $response->getTransactionReference());
		$this->assertSame('00', $response->getCode());
		$this->assertSame('Approved', $response->getMessage());
	}

	public function testSendFailure()
	{
		$this->setMockHttpResponse('SecureXMLStoredCardPurchaseRequestSendFailure.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\\SecurePay\\Message\\SecureXMLResponse', $response);

		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionReference());
		$this->assertSame('510', $response->getCode());
		$this->assertSame('Unable To Connect To Server', $response->getMessage());
	}

	public function testInsufficientFundsFailure()
	{
		$this->setMockHttpResponse('SecureXMLStoredCardPurchaseRequestInsufficientFundsFailure.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\\SecurePay\\Message\\SecureXMLResponse', $response);

		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionReference());
		$this->assertSame('51', $response->getCode());
		$this->assertSame('Insufficient Funds', $response->getMessage());
	}
}
