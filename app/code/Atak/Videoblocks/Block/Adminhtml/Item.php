<?php

namespace Atak\Videoblocks\Block\Adminhtml;

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
        $this->_blockGroup = 'Atak_Videoblocks';
        $this->_headerText = __('Videoblock');
        $this->_addButtonLabel = __('Create New Videoblock');
        parent::_construct();
    }
}