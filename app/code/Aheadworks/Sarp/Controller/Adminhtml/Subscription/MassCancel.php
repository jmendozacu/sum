<?php
namespace Aheadworks\Sarp\Controller\Adminhtml\Subscription;

use Aheadworks\Sarp\Api\Exception\OperationIsNotSupportedExceptionInterface;
use Aheadworks\Sarp\Api\ProfileManagementInterface;
use Aheadworks\Sarp\Model\ResourceModel\Profile\CollectionFactory;
use Aheadworks\Sarp\Model\Profile\Source\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassCancel
 * @package Aheadworks\Sarp\Controller\Adminhtml\Subscription
 */
class MassCancel extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Aheadworks_Sarp::subscriptions';

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ProfileManagementInterface
     */
    private $profileManagement;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProfileManagementInterface $profileManagement
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProfileManagementInterface $profileManagement
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->profileManagement = $profileManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $successCount = 0;
            $notSupportedCount = 0;
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            foreach ($collection->getAllIds() as $profileId) {
                try {
                    $this->profileManagement->changeStatusAction($profileId, Action::CANCEL);
                    $successCount++;
                } catch (OperationIsNotSupportedExceptionInterface $exception) {
                    $notSupportedCount++;
                } catch (\Exception $exception) {
                    throw $exception;
                }
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been cancelled.', $successCount)
            );
            if ($notSupportedCount > 0) {
                $this->messageManager->addNoticeMessage(
                    __(
                        'A total of %1 record(s) have not been cancelled '
                        . 'because this operation is not available.',
                        $notSupportedCount
                    )
                );
            }
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage(
                $exception,
                __('Something went wrong while cancel the items.')
            );
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
