<?php

namespace Eleanorsoft\AheadworksSarp\Block\Customer\Subscription;

use Aheadworks\Sarp\Api\ProfileRepositoryInterface;
use Aheadworks\Sarp\Block\Customer\Subscription\Actions as BaseActions;
use Aheadworks\Sarp\Model\SubscriptionEngine\EngineMetadataPool;
use Aheadworks\Sarp\Model\SubscriptionEngine\ProfileActionValidator;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Actions
 *
 * @package Eleanorsoft_AheadworksSarp
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Actions extends BaseActions
{

    /**
     * Check if skip next action is enabled
     *
     * @return bool
     */
    public function isSkipNextEnabled()
    {
        return parent::isCancelActionEnabled();
    }

    /**
     * Get activate url
     *
     * @return string
     */
    public function getActivateUrl()
    {
        $profileId = $this->getProfileId();
        return $this->_urlBuilder->getUrl(
            'aw_sarp/product/subscribe',
            [
                'es_active'=>'activate',
                'profile_id' => $profileId
            ]
        );
    }

    /**
     * Get skip next url
     *
     * @return string
     */
    public function getSkipNextUrl()
    {
        $profileId = $this->getProfileId();
        return $this->_urlBuilder->getUrl(
            'aw_sarp/product/subscribe',
            [
                'es_active'=>'activate',
                'es_skip_next'=>'skip next',
                'profile_id' => $profileId
            ]
        );
    }


    /**
     * Get profile ID
     *
     * @return int|null
     */
    private function getProfileId()
    {
        return $this->getRequest()->getParam('profile_id');
    }

}