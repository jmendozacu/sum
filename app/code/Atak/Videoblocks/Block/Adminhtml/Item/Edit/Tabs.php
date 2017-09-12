<?php

namespace Atak\Videoblocks\Block\Adminhtml\Item\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('videoblocks_item_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Videoblock Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'news_info',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Atak\Videoblocks\Block\Adminhtml\Item\Edit\Tab\Info'
                )->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }
}