<?php
namespace Aheadworks\Sarp\Controller\Adminhtml\Subscription;

use Aheadworks\Sarp\Api\ProfileManagementInterface;
use Aheadworks\Sarp\Model\Profile\Source\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Cancel
 * @package Aheadworks\Sarp\Controller\Adminhtml\Subscription
 */
class Cancel extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Aheadworks_Sarp::subscriptions';

    /**
     * @var ProfileManagementInterface
     */
    private $profileManagement;

    /**
     * @param Context $context
     * @param ProfileManagementInterface $profileManagement
     */
    public function __construct(
        Context $context,
        ProfileManagementInterface $profileManagement
    ) {
        parent::__construct($context);
        $this->profileManagement = $profileManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $profileId = $this->getRequest()->getParam('profile_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($profileId) {
            try {
                $this->profileManagement->changeStatusAction($profileId, Action::CANCEL);
                $this->messageManager->addSuccessMessage(__('The subscription was successfully cancelled.'));
            } catch (LocalizedException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage(
                    $exception,
                    __('Something went wrong while cancel the subscription.')
                );
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
