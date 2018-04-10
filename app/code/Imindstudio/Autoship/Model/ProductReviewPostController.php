<?php

namespace Imindstudio\Autoship\Model;

use Magento\Review\Model\Review;
use Magento\Review\Controller\Product\Post;
use Magento\Framework\Controller\ResultFactory;

class ProductReviewPostController extends Post
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Catalog\Model\Design $catalogDesign,
        \Magento\Framework\Session\Generic $reviewSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;

        parent::__construct(
            $context,
            $coreRegistry,
            $customerSession,
            $categoryRepository,
            $logger,
            $productRepository,
            $reviewFactory,
            $ratingFactory,
            $catalogDesign,
            $reviewSession,
            $storeManager,
            $formKeyValidator
        );
    }

    /**
     * Submit new review action
     *
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\Result\Json
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$this->formKeyValidator->validate($this->getRequest()) || !$this->getRequest()->isAjax()) {
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $messageData = [];
        $data = $this->reviewSession->getFormData(true);
        if ($data) {
            $rating = [];
            if (isset($data['ratings']) && is_array($data['ratings'])) {
                $rating = $data['ratings'];
            }
        } else {
            $data = $this->getRequest()->getPostValue();
            $rating = $this->getRequest()->getParam('ratings', []);
        }
        if (($product = $this->initProduct()) && !empty($data)) {
            /** @var \Magento\Review\Model\Review $review */

            if ($data['review_id']) {
                $review = $this->reviewFactory->create()->load($data['review_id']);
            } else {
                $review = $this->reviewFactory->create()->setData($data);
                $review->unsetData('review_id');
            }

            $validate = $review->validate();
            if ($validate === true) {
                try {
                    $review->setEntityId($review->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
                        ->setDetail($data['detail'])
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Review::STATUS_PENDING)
                        ->setCustomerId($this->customerSession->getCustomerId())
                        ->setStoreId($this->storeManager->getStore()->getId())
                        ->setStores([$this->storeManager->getStore()->getId()])
                        ->save();

                    foreach ($rating as $ratingId => $optionId) {
                        $this->ratingFactory->create()
                            ->setRatingId($ratingId)
                            ->setReviewId($review->getId())
                            ->setCustomerId($this->customerSession->getCustomerId())
                            ->addOptionVote($optionId, $product->getId());
                    }

                    $review->aggregate();
                    $messageData['success'] = __('You submitted your review for moderation.');
                } catch (\Exception $e) {
                    $this->reviewSession->setFormData($data);
                    $messageData['error'] = __('We can\'t post your review right now.');
                }
            } else {
                $this->reviewSession->setFormData($data);
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $messageData['error'] = __($errorMessage);
                    }
                } else {
                    $messageData['error'] = __('We can\'t post your review right now.');
                }
            }
        }

        return $this->resultJsonFactory->create()->setData($messageData);
    }
}
