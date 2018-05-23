<?php

namespace Eleanorsoft\AheadworksSarp\Model\SubscriptionEngine\Authorizenet;

use Aheadworks\Sarp\Model\Profile\Source\Action;
use Aheadworks\Sarp\Model\Profile\Source\Status;
use Aheadworks\Sarp\Model\SubscriptionEngine\Authorizenet\Engine as BaseEngine;

/**
 * Class Engine
 * Extends base class Engine, for add action: suspend, activate
 *
 * @package Eleanorsoft_AheadworksSarp
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Engine extends BaseEngine
{

    /**
     * Changes the status depending on the action
     *
     * @param $referenceId
     * @param $action
     * @param array $additionalData
     * @return null|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function changeStatus($referenceId, $action, $additionalData = [])
    {
        if ($action == Action::SUSPEND){
            $action = Action::CANCEL;
            $status = parent::changeStatus($referenceId, $action, $additionalData);

            if ($status != Status::CANCELLED){
                return $status;
            }
            return Status::SUSPENDED;
        }

        return parent::changeStatus($referenceId, $action, $additionalData);
    }
}