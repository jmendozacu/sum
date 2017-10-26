<?php

namespace Eleanorsoft\Customer\Plugin\Customer\Controller\Address;

class FormPost
{
    public function afterExecute(
        \Magento\Customer\Controller\Address\FormPost $subject,
        \Magento\Framework\Controller\Result\Redirect $result
    ) {
        return $result->setPath('*/account/edit');
    }
}
