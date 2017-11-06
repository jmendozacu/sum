<?php

namespace Eleanorsoft\EndSubscriptionQuiz\Model\Config\Source;

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        $this->_options = [];

        $itemsCollection = [
            ['key' => 1, 'value' => 'CHOSE ANOTER PLAN'],
            ['key' => 2, 'value' => 'DON’T LIKE THE PRODUCTS'],
            ['key' => 3, 'value' => 'BE BACK SOON']
        ];

        foreach ($itemsCollection as $item) {
            $this->_options[] = ['label' => __($item['value']), 'value' => $item['key']];
        }

        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
