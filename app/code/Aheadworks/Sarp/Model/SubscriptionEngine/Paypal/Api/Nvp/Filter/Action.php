<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Api\Nvp\Filter;

/**
 * Class Action
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Api\Nvp\Filter
 */
class Action implements \Zend_Filter_Interface
{
    /**
     * {@inheritdoc}
     */
    public function filter($value)
    {
        switch ($value) {
            case 'cancel':
                return 'Cancel';
            case 'suspend':
                return 'Suspend';
            case 'activate':
                return 'Reactivate';
            default:
                break;
        }
        return '';
    }
}
