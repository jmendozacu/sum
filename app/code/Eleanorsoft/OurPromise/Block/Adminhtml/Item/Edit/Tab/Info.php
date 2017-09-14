<?php

namespace Eleanorsoft\OurPromise\Block\Adminhtml\Item\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;

class Info extends Generic implements TabInterface
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /** @var $model \Atak\Events\Model\Item */
        $model = $this->_coreRegistry->registry('ourpromise_item');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $form->setFieldNameSuffix('item');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                ['name' => 'id']
            );
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name'      => 'title',
                'label'     => __('Title'),
                'required'  => true
            ]
        );
        
        $fieldset->addField(
            'slug',
            'text',
            [
                'name'      => 'slug',
                'label'     => __('Slug'),
                'required'  => true
            ]
        );

        $fieldset->addField(
            'background_image',
            'image',
            [
                'name'      => 'background_image',
                'label'     => __('Background Image'),
                'required'  => true
            ]
        );
        
        $fieldset->addField(
            'icon',
            'image',
            [
                'name'      => 'icon',
                'label'     => __('Icon'),
                'required'  => true
            ]
        );
        
        $fieldset->addField(
            'short_description',
            'textarea',
            [
                'name'      => 'short_description',
                'label'     => __('Short Description'),
                'required'  => false
            ]
        );

        $fieldset->addField(
            'content',
            'editor',
            [
                'name'      => 'content',
                'label'     => __('Content'),
                'rows' => '10',
                'cols' => '30',
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig(),
                'required'  => true
            ]
        );

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name'      => 'sort_order',
                'label'     => __('Sort Order'),
                'required'  => true
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name'      => 'is_active',
                'label'     => __('Is Active'),
                'required'  => true,
                'options'   => ['1' => __('Yes'), '0' => __('No')]
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Item Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Item Info');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}