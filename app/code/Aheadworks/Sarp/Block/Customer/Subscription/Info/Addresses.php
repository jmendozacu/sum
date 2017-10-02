<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Block\Customer\Subscription\Info;

use Aheadworks\Sarp\Api\Data\ProfileInterface;
use Aheadworks\Sarp\Api\Data\ProfileAddressInterface;
use Aheadworks\Sarp\Api\ProfileRepositoryInterface;
use Aheadworks\Sarp\Block\Customer\Subscription\Info\Address\Form as AddressForm;
use Aheadworks\Sarp\Model\SubscriptionEngine\EngineMetadataPool;
use Aheadworks\Sarp\Model\SubscriptionsCart\Address;
use Aheadworks\Sarp\Model\SubscriptionsCart\Address\Resolver\FullName as FullNameResolver;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template\Context;
use Magento\Directory\Api\CountryInformationAcquirerInterface;

/**
 * Class Addresses
 * @package Aheadworks\Sarp\Block\Customer\Subscription\Info
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Addresses extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ProfileRepositoryInterface
     */
    private $profileRepository;

    /**
     * @var Session
     */
    private $customerSession;

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
     * @param Context $context
     * @param ProfileRepositoryInterface $profileRepository
     * @param Session $customerSession
     * @param FullNameResolver $fullNameResolver
     * @param CountryInformationAcquirerInterface $countryInformation
     * @param EngineMetadataPool $engineMetadataPool
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProfileRepositoryInterface $profileRepository,
        Session $customerSession,
        FullNameResolver $fullNameResolver,
        CountryInformationAcquirerInterface $countryInformation,
        EngineMetadataPool $engineMetadataPool,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->profileRepository = $profileRepository;
        $this->customerSession = $customerSession;
        $this->fullNameResolver = $fullNameResolver;
        $this->countryInformation = $countryInformation;
        $this->engineMetadataPool = $engineMetadataPool;
    }

    /**
     * Get profile ID
     *
     * @return int|null
     */
    private function getProfileId()
    {
        return $this->getRequest()->getParam('profile_id');
    }

    /**
     * Get profile
     *
     * @return ProfileInterface
     */
    public function getProfile()
    {
        return $this->profileRepository->get($this->getProfileId());
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
     * Get edit address form html
     *
     * @param ProfileAddressInterface $address
     * @return string
     * @throws LocalizedException
     */
    public function getEditAddressFormHtml($address)
    {
        /** @var AddressForm $block */
        $block = $this->getLayout()->createBlock(
            AddressForm::class,
            '',
            ['data' => ['address' => $address]]
        );
        return $block->toHtml();
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
        if (!$this->getProfileId() || !$this->customerSession->isLoggedIn()) {
            return '';
        }
        return parent::_toHtml();
    }
}
