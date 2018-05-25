<?php

namespace Eleanorsoft\PageTitle\Plugin\MirasvitRewards;

use Magento\Framework\View\Result\Page;
use Mirasvit\Rewards\Controller\Account as Subject;

/**
 * Class AccountIndexControllerPlugin
 *
 * @package Eleanorsoft\PageTitle\Plugin\MirasvitRewards
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class AccountIndexControllerPlugin
{
    /**
     * @param Subject $subject
     * @param Page $page
     * @return Page
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function afterExecute(Subject $subject, Page $page)
    {
        $page->getConfig()->getTitle()->set(__('My Reward Points'));

        return $page;
    }
}
