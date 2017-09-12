<?php

namespace Atak\Praise\Controller\Adminhtml\Item;

use Atak\Praise\Controller\Adminhtml\Item\Index;

class NewAction extends Index
{
    /**
     * Create new news action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}