<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Delete Payor Request.
 *
 * Delete Payor for periodical payment
 *
 */
class SecureXMLDeletePayorRequest extends SecureXMLAbstractRequest
{
    protected $actionType = 'delete';
    protected $requiredFields = array('card');

    public function getData()
    {
        $xml = $this->getBasePaymentXML();
        
        $xml->Periodic->PeriodicList->PeriodicItem->addChild('periodicType', 4);

         return $xml;
    }
}
