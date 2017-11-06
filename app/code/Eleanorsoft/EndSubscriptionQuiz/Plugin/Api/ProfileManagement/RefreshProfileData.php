<?php

namespace Eleanorsoft\EndSubscriptionQuiz\Plugin\Api\ProfileManagement;

class RefreshProfileData
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

    public function aroundRefreshProfileData(\Aheadworks\Sarp\Api\ProfileManagementInterface $subject, callable $proceed, ...$args)
    {
        try {
            $profileId = $this->_request->getParam('profile_id');
            $profile = $this->_profileFactory->create()->load($profileId);
            $oldReason = $profile->getData('erst_reason');

            $result = $proceed(...$args);

            $profile = $this->_profileFactory->create()->load($profileId);

            $profile->setData('erst_reason', $oldReason ? $oldReason : __('Reason N/A'));
            $profile->save();
        } catch (\Exception $ex) {

            throw $ex;
        }

        return $result;
    }
}
