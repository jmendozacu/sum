<?php

namespace Eleanorsoft\Customer\Plugin\Customer\Controller\Address;

class Delete
{
    public function afterExecute(
        \Magento\Customer\Controller\Address\Delete $subject,
        \Magento\Framework\Controller\Result\Redirect $result
    ) {
        return $result->setPath('*/account/edit');
    }
}
