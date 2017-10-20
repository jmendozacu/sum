<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\WebHook\Handlers;

use Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\WebHook\HandlerInterface;
use Magento\Framework\DataObject;

/**
 * todo: consider remove this
 * Class InvoiceCreated
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\WebHook\Handlers
 */
class InvoiceCreated implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(DataObject $eventObject)
    {
        // Used only to get response code 200
    }
}
