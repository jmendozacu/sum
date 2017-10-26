<?php

namespace Eleanorsoft\Customer\Block\Account\Dashboard\Chunks;

class Address extends \Magento\Framework\View\Element\Template
{
    protected $_address;
    protected $_countryFactory;

    public function __construct(
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->_countryFactory = $countryFactory;

        parent::__construct($context);
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function getCountryNameByCode($code)
    {
        return $this->_countryFactory->create()->loadByCode($code)->getName();
    }

    public function getAddressHtml($address)
    {
        $this->_address = $address;

        return $this->toHtml();
    }
}
