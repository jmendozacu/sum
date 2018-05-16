<?php
namespace Eleanorsoft\AheadworksSarp\Block\Customer\Subscription\Info;

use Magento\Framework\View\Element\Template;
/**
 * Class Products
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Products extends Template
{

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
     * todo: What is its purpose? What does it do?
     *
     * @return string
     */
    public function getAjaxUrlSubscriptionProductsList()
    {
        return $this->getUrl('es_sarp/product/info',
            array('profile_id' => $this->getProfileId()));
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @return string
     */
    public function getAjaxUrlProductsList() {
        return $this->getUrl('es_sarp/product/productList');
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @return string
     */
    public function getAjaxUrlAddProduct()
    {
        return $this->getUrl('es_sarp/product/addProduct');
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @return string
     */
    public function getAjaxUrlSaveProduct()
    {
        return $this->getUrl('es_sarp/product/saveProduct',
            array('profile_id' => $this->getProfileId()));
    }
}