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

        $card = $xml->Periodic->PeriodicList->PeriodicItem->addChild('CreditCardInfo');
        $card->addChild('cardNumber', $this->getCard()->getNumber());
        $card->addChild('cvv', $this->getCard()->getCvv());
        $card->addChild('expiryDate', $this->getCard()->getExpiryDate('m/y'));

        $xml->Periodic->PeriodicList->PeriodicItem->addChild('periodicType', 4);
        $xml->Periodic->PeriodicList->PeriodicItem->actionType = 'add';

        return $xml;
    }
}
