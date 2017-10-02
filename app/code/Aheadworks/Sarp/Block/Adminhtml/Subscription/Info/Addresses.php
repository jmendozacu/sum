<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Block\Adminhtml\Subscription\Info;

use Aheadworks\Sarp\Api\Data\ProfileInterface;
use Aheadworks\Sarp\Api\Data\ProfileAddressInterface;
use Aheadworks\Sarp\Model\SubscriptionEngine\EngineMetadataPool;
use Aheadworks\Sarp\Model\SubscriptionsCart\Address;
use Aheadworks\Sarp\Model\SubscriptionsCart\Address\Resolver\FullName as FullNameResolver;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Api\CountryInformationAcquirerInterface;

/**
 * Class Addresses
 * @package Aheadworks\Sarp\Block\Adminhtml\Subscription\Info
 */
class Addresses extends \Magento\Backend\Block\Template
{
    /**
     * @var FullNameResolver
     */
    private $fullNameResolver;

    /**
     * @var CountryInformationAcquirerInterface
     */
    private $countryInformation;

    /**
     * @var EngineMetadataPool
     */
    private $engineMetadataPool;

    /**
     * @var ProfileInterface
     */
    private $profile;

    /**
     * {@inheritdoc}
     */
    protected $_template = 'Aheadworks_Sarp::subscription/info/addresses.phtml';

    /**
     * @param Context $context
     * @param FullNameResolver $fullNameResolver
     * @param CountryInformationAcquirerInterface $countryInformation
     * @param EngineMetadataPool $engineMetadataPool
     * @param array $data
     */
    public function __construct(
        Context $context,
        FullNameResolver $fullNameResolver,
        CountryInformationAcquirerInterface $countryInformation,
        EngineMetadataPool $engineMetadataPool,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->fullNameResolver = $fullNameResolver;
        $this->countryInformation = $countryInformation;
        $this->engineMetadataPool = $engineMetadataPool;
    }

    /**
     * Get profile entity
     *
     * @return ProfileInterface
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set profile entity
     *
     * @param ProfileInterface $profile
     * @return $this
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get shipping address
     *
     * @return ProfileAddressInterface|null
     */
    public function getShippingAddress()
    {
        if (!$this->getProfile()->getIsCartVirtual()) {
            foreach ($this->getProfile()->getAddresses() as $address) {
                if ($address->getAddressType() == Address::TYPE_SHIPPING) {
                    return $address;
                }
            }
        }
        return null;
    }

    /**
     * Get billing address
     *
     * @return ProfileAddressInterface|null
     */
    public function getBillingAddress()
    {
        foreach ($this->getProfile()->getAddresses() as $address) {
            if ($address->getAddressType() == Address::TYPE_BILLING) {
                return $address;
            }
        }
        return null;
    }

    /**
     * Get full name
     *
     * @param ProfileAddressInterface $address
     * @return string
     */
    public function getFullName($address)
    {
        return $this->fullNameResolver->getFullName($address);
    }

    /**
     * Get country name
     *
     * @param string $countryId
     * @return string
     */
    public function getCountryName($countryId)
    {
        $countryInfo = $this->countryInformation->getCountryInfo($countryId);
        return $countryInfo->getFullNameLocale();
    }

    /**
     * Get payment method name
     *
     * @return string
     * @throws \Exception
     */
    public function getPaymentMethodName()
    {
        $engineMetadata = $this->engineMetadataPool->getMetadata(
            $this->getProfile()->getEngineCode()
        );
        return $engineMetadata->getLabel();
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        if (!$this->getProfile()) {
            return '';
        }
        return parent::_toHtml();
    }
}
