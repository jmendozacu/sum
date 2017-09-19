<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eleanorsoft\Ingredients\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\Component\Form\Field;
use Magento\Catalog\Api\Data\ProductAttributeInterface;


class AttributeSet extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AttributeSet
{
    public function modifyMeta(array $meta)
    {
        if ($name = $this->getGeneralPanelName($meta)) {
            $product = $this->locator->getProduct();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $helperBackend = $objectManager->get('\Magento\Backend\Helper\Data');
            $ingredients = $objectManager->get('Eleanorsoft\Ingredients\Model\Ingredients');

            $meta[$name]['children']['attribute_set_id']['arguments']['data']['config'] = [
                'component' => 'Magento_Catalog/js/components/attribute-set-select',
                'disableLabel' => true,
                'filterOptions' => true,
                'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                'formElement' => 'select',
                'componentType' => Field::NAME,
                'options' => $this->getOptions(),
                'visible' => 1,
                'required' => 1,
                'label' => __('Attribute Set'),
                'source' => $name,
                'dataScope' => 'attribute_set_id',
                'filterUrl' => $this->urlBuilder->getUrl('catalog/product/suggestAttributeSets', ['isAjax' => 'true']),
                'sortOrder' => $this->getNextAttributeSortOrder(
                    $meta,
                    [ProductAttributeInterface::CODE_STATUS],
                    self::ATTRIBUTE_SET_FIELD_ORDER
                ),
                'multiple' => false
            ];

            if ($product->getAttributeSetId() == $ingredients->getAttributeSetId()) {
                $meta[$name]['children']['attribute_set_id']['arguments']['data']['config']['tooltip'] = [
                    'link' => $helperBackend->getUrl(
                        'catalog/product_attribute/edit/attribute_id/' . $ingredients->getAttributeId()
                    ),
                    'description' => __('Add Ingredients Category')
                ];
            }
        }

        return $meta;
    }
}
