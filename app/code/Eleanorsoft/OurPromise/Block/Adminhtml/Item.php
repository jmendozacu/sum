<?php

namespace Eleanorsoft\OurPromise\Block\Adminhtml;

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
        $this->_blockGroup = 'Eleanorsoft_OurPromise';
        $this->_headerText = __('Promises');
        $this->_addButtonLabel = __('Create New Promise');
        parent::_construct();
    }
}