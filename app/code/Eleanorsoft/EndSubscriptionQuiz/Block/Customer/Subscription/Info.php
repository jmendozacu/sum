<?php

namespace Eleanorsoft\EndSubscriptionQuiz\Block\Customer\Subscription;

class Info extends \Aheadworks\Sarp\Block\Customer\Subscription\Info
{
    protected $_profileModel;
    protected $_profileFactory;

    public function __construct(
        \Aheadworks\Sarp\Model\ProfileFactory $profileFactory,
        \Magento\Framework\View\Element\Template\Context $context,
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
