<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Store Card Update Request.
 *
 * Send a request to update the details a stored PayorID
 *
 * The cardReference must match the prior existing stored card.
 */
class SecureXMLEditCardRequest extends SecureXMLAbstractRequest
{
    /**
     * @var string
     */
    public $testEndpoint = 'https://test.api.securepay.com.au/xmlapi/periodic';

    /**
     * @var string
     */
    public $liveEndpoint = 'https://api.securepay.com.au/xmlapi/periodic';

    protected $requiredFields = ['card', 'cardReference'];

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
        $xml = $this->getBaseStoredCardXML('edit');

        $this->getCard()->validate();
        $card = $xml->Periodic->PeriodicList->PeriodicItem->addChild('CreditCardInfo');
        $card->addChild('cardNumber', $this->getCard()->getNumber());
        $card->addChild('cvv', $this->getCard()->getCvv());
        $card->addChild('expiryDate', $this->getCard()->getExpiryDate('m/y'));

        return $xml;
    }
}
