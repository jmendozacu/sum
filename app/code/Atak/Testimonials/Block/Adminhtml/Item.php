<?php

namespace Atak\Testimonials\Block\Adminhtml;

class Item extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_item';
        $this->_blockGroup = 'Atak_Testimonials';
        $this->_headerText = __('Testimonials');
        $this->_addButtonLabel = __('Create New Testimonial');
        parent::_construct();
    }
}