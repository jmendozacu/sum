<?php

namespace Imindstudio\Autoship\Block;

class Reviews extends \Magento\Framework\View\Element\Template
{
    private $_ratingObject;
    private $_imageHelperObject;

    protected $_review;
    protected $_ratingFactory;
    protected $_customerSession;
    protected $_orderRepository;
    protected $_productRepository;
    protected $_imageHelperFactory;

    public function __construct(
        \Magento\Review\Model\Review $review,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);

        $this->_review              = $review;
        $this->_ratingFactory       = $ratingFactory;
        $this->_customerSession     = $customerSession;
        $this->_orderRepository     = $orderRepository;
        $this->_productRepository   = $productRepository;
        $this->_imageHelperFactory  = $imageHelperFactory;
    }

    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    public function getOrder()
    {
        return $this->_orderRepository->get(
            $this->getRequest()->getParam('order_id')
        );
    }

    public function getAction($id)
    {
        return $this->getUrl(
            'review/product/post',
            [
                '_secure'   => $this->getRequest()->isSecure(),
                'id'        => $id
            ]
        );
    }

    public function getProductImageUrlByProduct($product)
    {
        if (!$this->_imageHelperObject) {
            $this->_imageHelperObject = $this->_imageHelperFactory->create();
        }

        return $this->_imageHelperObject->init(
            $product, 'product_small_image'
        )->getUrl();
    }

    public function getCustomerProductReviewByProductId($productId)
    {
        if (!$this->_ratingObject) {
            $this->_ratingObject = $this->_ratingFactory->create();
        }

        $data = new \stdClass();
        $review = $this->_review->getResourceCollection()
            ->addStoreFilter($this->_storeManager->getStore()->getId())
            ->addEntityFilter('product', $productId)
            ->addCustomerFilter($this->_customerSession->getCustomer()->getId())
            ->setDateOrder()
            ->getFirstItem();
        $rating = $this->_ratingObject->getReviewSummary((int)$review['review_id']);
        $data->id = $review->getId();
        $data->detail = $review->getDetail();
        $data->rating = $this->transformRating($rating->getSum());
        $data->statusId = $review->getStatusId();
        $data->isApproved = false;

        if ($data->detail && $review->getStatusId() != \Magento\Review\Model\Review::STATUS_NOT_APPROVED) {
            $data->isApproved = true;
        }

        return $data;
    }

    private function transformRating($ratingValue) {
        switch ((int)$ratingValue) {
            case 20: return 16; break;
            case 40: return 17; break;
            case 60: return 18; break;
            case 80: return 19; break;
            case 100: return 20; break;
            default: return 0; break;
        }
    }
}
