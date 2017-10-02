<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\SubscriptionsCart\Address;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface;
use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validator\AbstractValidator;

/**
 * Class Validator
 * @package Aheadworks\Sarp\Model\SubscriptionsCart\Address
 */
class Validator extends AbstractValidator
{
    /**
     * @var CountryInformationAcquirerInterface
     */
    private $countryInformation;

    /**
     * @param CountryInformationAcquirerInterface $countryInformation
     */
    public function __construct(CountryInformationAcquirerInterface $countryInformation)
    {
        $this->countryInformation = $countryInformation;
    }

    /**
     * Returns true if and only if address entity meets the validation requirements
     *
     * @param SubscriptionsCartAddressInterface $address
     * @return bool
     */
    public function isValid($address)
    {
        $this->_clearMessages();

        $email = $address->getEmail();
        if ($email && !\Zend_Validate::is($email, 'EmailAddress')) {
            $this->_addMessages(['Invalid email format.']);
        }

        $countryId = $address->getCountryId();
        if ($countryId) {
            try {
                $this->countryInformation->getCountryInfo($countryId);
            } catch (NoSuchEntityException $e) {
                $this->_addMessages(['Invalid country code.']);
            }
        }

        return empty($this->getMessages());
    }
}
