<?php

namespace Atak\Testimonials\Block\Adminhtml\Item\Edit\Tab;

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
        $model = $this->_coreRegistry->registry('testimonials_item');

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
            'name',
            'text',
            [
                'name'        => 'name',
                'label'    => __('Name'),
                'required'     => true
            ]
        );

        $fieldset->addField(
            'subtitle',
            'text',
            [
                'name'        => 'subtitle',
                'label'    => __('Sub-Title'),
                'required'     => false
            ]
        );

        $fieldset->addField(
            'text',
            'textarea',
            [
                'name'        => 'text',
                'label'    => __('Text'),
                'required'     => true
            ]
        );

        $fieldset->addField(
            'image',
            'image',
            [
                'name'        => 'image',
                'label'    => __('Image'),
                'required'     => true
            ]
        );

        $fieldset->addField(
            'order_number',
            'text',
            [
                'name'        => 'order_number',
                'label'    => __('Order Number'),
                'required'     => true
            ]
        );

        $fieldset->addField(
            'is_enabled',
            'select',
            [
                'name'        => 'is_enabled',
                'label'    => __('Is Enabled'),
                'required' => true,
                'options' => ['1' => __('Yes'), '0' => __('No')]
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
        return __('Testimonial Info');
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