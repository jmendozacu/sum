<?php

namespace Eleanorsoft\Customer\Block\Account\Dashboard;

use Magento\Framework\Exception\NoSuchEntityException;

class Address extends \Magento\Customer\Block\Account\Dashboard\Address
{
    protected $customerRepository;

    public function __construct(
        \Magento\Customer\Model\Address\Config $addressConfig,
        \Magento\Customer\Model\Address\Mapper $addressMapper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Helper\Session\CurrentCustomerAddress $currentCustomerAddress,
        array $data
    ) {
        $this->customerRepository = $customerRepository;

        parent::__construct(
            $context,
            $currentCustomer,
            $currentCustomerAddress,
            $addressConfig,
            $addressMapper,
            $data);
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('customer/address/delete');
    }

    public function getDefaultBilling()
    {
        $customer = $this->getCustomer();

        if ($customer === null) {
            return null;
        } else {
            return $customer->getDefaultBilling();
        }
    }

    public function getDefaultShipping()
    {
        $customer = $this->getCustomer();

        if ($customer === null) {
            return null;
        } else {
            return $customer->getDefaultShipping();
        }
    }

    public function getPrimaryShippingAddress()
    {
        try {
            $address = $this->currentCustomerAddress->getDefaultShippingAddress();
        } catch (NoSuchEntityException $e) {
            $address = null;
        }

        return $address;
    }

    public function getPrimaryBillingAddress()
    {
        try {
            $address = $this->currentCustomerAddress->getDefaultBillingAddress();
        } catch (NoSuchEntityException $e) {
            $address = null;
        }

        return $address;
    }

    public function getAdditionalAddresses()
    {
        try {
            $addresses = $this->customerRepository->getById($this->currentCustomer->getCustomerId())->getAddresses();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return false;
        }

        $primaryAddressIds = [$this->getDefaultBilling(), $this->getDefaultShipping()];

        foreach ($addresses as $address) {
            if (!in_array($address->getId(), $primaryAddressIds)) {
                $additional[] = $address;
            }
        }

        return empty($additional) ? false : $additional;
    }
}
