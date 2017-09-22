<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Eleanorsoft\HowTo\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    private $_eavSetupFactory;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $attrCode = 'how_to';
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            $attrCode,
            [
                'type'                      => 'text',
                'backend'                   => '',
                'frontend'                  => '',
                'label'                     => '',
                'input'                     => 'textarea',
                'class'                     => '',
                'source'                    => '',
                'global'                    => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible'                   => true,
                'required'                  => false,
                'user_defined'              => false,
                'default'                   => '[]',
                'searchable'                => false,
                'filterable'                => false,
                'comparable'                => false,
                'visible_on_front'          => false,
                'used_in_product_listing'   => true,
                'unique'                    => false,
            ]
        );
    }
}
