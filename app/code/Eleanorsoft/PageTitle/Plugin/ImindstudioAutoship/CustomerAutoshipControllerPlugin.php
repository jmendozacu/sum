<?php

namespace Eleanorsoft\PageTitle\Plugin\ImindstudioAutoship;

use Magento\Framework\App\ViewInterface;
use Imindstudio\Autoship\Controller\Customer\Autoship as Subject;

/**
 * Class CustomerAutoshipControllerPlugin
 *
 * @package Eleanorsoft\PageTitle\Plugin\ImindstudioAutoship
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class CustomerAutoshipControllerPlugin
{
    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * CustomerAutoshipControllerPlugin constructor.
     *
     * @param ViewInterface $view
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        ViewInterface $view
    ) {
        $this->view = $view;
    }

    /**
     * @param Subject $subject
     * @param callable $proceed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function aroundExecute(Subject $subject, callable $proceed)
    {
        $this->view->loadLayout();

        $pageConfig = $this->view->getPage()->getConfig();

        $pageConfig->getTitle()->set(__('Your Auto Ship'));

        $this->view->renderLayout();
    }
}
