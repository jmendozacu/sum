<?php

namespace Eleanorsoft\EndSubscriptionQuiz\Plugin\Api\ProfileManagement;

class ChangeStatusAction
{
    protected $_request;
    protected $_profileFactory;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Aheadworks\Sarp\Model\ProfileFactory $profileFactory
    ) {
        $this->_request = $request;
        $this->_profileFactory = $profileFactory;
    }

    public function aroundChangeStatusAction(\Aheadworks\Sarp\Api\ProfileManagementInterface $subject, callable $proceed, ...$args)
    {
        try {
            $profileId = $this->_request->getParam('profile_id');
            $profile = $this->_profileFactory->create()->load($profileId);
            $oldReason = $profile->getData('erst_reason');

            $result = $proceed(...$args);

            $reason = $this->_request->getParam('erst_reason');
            $profile = $this->_profileFactory->create()->load($profileId);

            if(!$reason) {
                $reason = $oldReason ? $oldReason : __('Reason N/A');
            }

            $profile->setData('erst_reason', $reason);
            $profile->save();
        } catch (\Exception $ex) {
            throw $ex;
        }

        return $result;
    }
}
