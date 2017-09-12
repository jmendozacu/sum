<?php

namespace Atak\Praise\Block\Adminhtml;

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
        $this->_blockGroup = 'Atak_Praise';
        $this->_headerText = __('Praise');
        $this->_addButtonLabel = __('Create New Praise');
        parent::_construct();
    }
}