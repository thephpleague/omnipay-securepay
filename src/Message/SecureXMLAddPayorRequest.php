<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Add Payor Request.
 *
 * Add Payor for periodical payment
 *
 */
class SecureXMLAddPayorRequest extends SecureXMLAbstractRequest
{
    protected $actionType = 'add'; 
    protected $requiredFields = array('amount', 'card', 'currency');

    public function getData()
    {
        $xml = $this->getBasePaymentXML();

       	$xml = $this->getCardXML($xml);

        $xml->Periodic->PeriodicList->PeriodicItem->addChild('periodicType', 4);

        return $xml;
    }
}
