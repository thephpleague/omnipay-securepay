<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Payment Using Stored Card.
 *
 * Perform a purchase using a stored card.
 *
 * The cardReference must be sent in order to successfully process the purchase
 */
class SecureXMLStoredCardPurchaseRequest extends SecureXMLAbstractRequest
{
    /**
     * @var string
     */
    public $testEndpoint = 'https://test.api.securepay.com.au/xmlapi/periodic';

    /**
     * @var string
     */
    public $liveEndpoint = 'https://api.securepay.com.au/xmlapi/periodic';

    protected $requiredFields = ['amount', 'cardReference', 'transactionId'];

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
        $xml = $this->getBaseStoredCardXML('trigger');
        $periodicItem = $xml->Periodic->PeriodicList->PeriodicItem;
        $periodicItem->addChild('transactionReference', $this->getTransactionId());
        $periodicItem->addChild('amount', $this->getAmountInteger());
        $periodicItem->addChild('periodicType', 1); // Appendix A "Add a Payor ID"

        return $xml;
    }
}
