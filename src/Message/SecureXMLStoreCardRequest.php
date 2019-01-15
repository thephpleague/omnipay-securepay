<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Store Card Request.
 *
 * Send a request to store the details a new credit card.
 *
 * The cardReference must be sent and must be unique in order to successfully create a new payor.
 */
class SecureXMLStoreCardRequest extends SecureXMLAbstractRequest
{
    /**
     * @var string
     */
    public $testEndpoint = 'https://test.api.securepay.com.au/xmlapi/periodic';

    /**
     * @var string
     */
    public $liveEndpoint = 'https://api.securepay.com.au/xmlapi/periodic';


    protected $requiredFields = ['amount', 'card', 'cardReference'];

    /**
     * @var string
     */
    protected $requestType = 'Periodic';

    /**
     * @var string
     */
    protected $apiVersion = 'spxml-4.2';

    public function getData()
    {
        $xml = $this->getBaseStoredCardXML('add');

        $this->getCard()->validate();
        $card = $xml->Periodic->PeriodicList->PeriodicItem->addChild('CreditCardInfo');
        $card->addChild('cardNumber', $this->getCard()->getNumber());
        $card->addChild('cvv', $this->getCard()->getCvv());
        $card->addChild('expiryDate', $this->getCard()->getExpiryDate('m/y'));
        $xml->addChild('amount', $this->getAmountInteger());
        $xml->addChild('periodicType', 4); // Appendix A "Add a Payor ID"

        return $xml;
    }
}
