<?php

namespace Imindstudio\Autoship\Controller\Customer;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_url;
    protected $_http;
    protected $_request;
    protected $_customerSession;
    protected $_orderRepository;
    protected $_resultPageFactory;

    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Response\Http $http,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->_url = $url;
        $this->_http = $http;
        $this->_request = $request;
        $this->_orderRepository = $orderRepository;
        $this->_customerSession = $customerSession;
        $this->_resultPageFactory = $resultPageFactory;
    }

	public function execute()
    {
        $orderId = $this->_request->getParam('order_id');

        if ($this->_customerSession->isLoggedIn() && $orderId) {
            $order = $this->_orderRepository->get($orderId);

            if ($order->getState() == \Magento\Sales\Model\Order::STATE_COMPLETE) {
                $this->_resultPageFactory->create()
                     ->getConfig()
                     ->getTitle()
                     ->set(__('PENDING REVIEWS'));
                $this->_view->loadLayout();
                $this->_view->renderLayout();
            } else {
                $this->accountRedirect();
            }
        } else {
            $this->accountRedirect();
        }
	}

	private function accountRedirect() {
        $this->_http->setRedirect($this->_url->getUrl('customer/account'), 301);
    }
}
