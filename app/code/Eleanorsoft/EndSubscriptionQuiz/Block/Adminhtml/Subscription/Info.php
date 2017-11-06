<?php

namespace Eleanorsoft\EndSubscriptionQuiz\Block\Adminhtml\Subscription;

class Info extends \Aheadworks\Sarp\Block\Adminhtml\Subscription\Info
{
    protected $_template = 'Eleanorsoft_EndSubscriptionQuiz::subscription/info.phtml';

    protected $_profileModel;
    protected $_profileFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Aheadworks\Sarp\Model\ProfileFactory $profileFactory,
        \Aheadworks\Sarp\Model\Profile\Source\Status $statusSource,
        \Aheadworks\Sarp\Api\ProfileRepositoryInterface $profileRepository,
        array $data = []
    ) {
        $this->_profileFactory = $profileFactory;

        parent::__construct($context, $profileRepository, $statusSource, $data);
    }

    public function getStatus()
    {
        return $this->getProfile()->getStatus();
    }

    public function getReason()
    {
        return $this->getProfileModel()->getErstReason();
    }

    public function getProfileModel()
    {
        if (!$this->_profileModel) {
            $this->_profileModel = $this->_profileFactory->create()
                ->load($this->getProfile()->getProfileId());
        }

        return $this->_profileModel;
    }
}
