<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Store Card Delete Request.
 *
 * Send a request to delete a stored PayorID from Securepay's system
 *
 * The cardReference must match the prior existing stored card.
 */
class SecureXMLDeleteCardRequest extends SecureXMLAbstractRequest
{
    /**
     * @var string
     */
    public $testEndpoint = 'https://test.api.securepay.com.au/xmlapi/periodic';

    /**
     * @var string
     */
    public $liveEndpoint = 'https://api.securepay.com.au/xmlapi/periodic';

    protected $requiredFields = ['cardReference'];

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
        return $this->getBaseStoredCardXML('delete');
    }
}
