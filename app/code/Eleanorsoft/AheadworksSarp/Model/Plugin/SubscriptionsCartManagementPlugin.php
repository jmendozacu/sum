<?php

namespace Eleanorsoft\AheadworksSarp\Model\Plugin;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartInterface;
use Aheadworks\Sarp\Api\ProfileRepositoryInterface;
use Aheadworks\Sarp\Api\SubscriptionsCartManagementInterface;
use Aheadworks\Sarp\Model\Session;
use Eleanorsoft\AheadworksSarp\Helper\Data;

/**
 * Class SubscriptionsCartManagementPlugin
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class SubscriptionsCartManagementPlugin
{

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Data
     */
    protected $data;

    /**
     * @var ProfileRepositoryInterface
     */
    protected $profileRepository;

    /**
     * SubscriptionsCartManagementPlugin constructor.
     * @param Session $session
     * @param Data $data
     * @param ProfileRepositoryInterface $profileRepository
     */
    public function __construct
    (
        Session $session,
        Data $data,
        ProfileRepositoryInterface $profileRepository
    )
    {
        $this->session = $session;
        $this->data = $data;
        $this->profileRepository = $profileRepository;
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @param SubscriptionsCartManagementInterface $subject
     * @param SubscriptionsCartInterface $cart
     * @return SubscriptionsCartInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterSubmit(SubscriptionsCartManagementInterface $subject, SubscriptionsCartInterface $cart)
    {
        $card_id = $cart->getCartId();

        $profile_id_session = $this->session->getProfileId();
        $card_id_session = $this->session->getSuccessCartId();

        if ($card_id == $card_id_session) {
            $profile = $this->data->getProfile($profile_id_session);
            $profile->setStatus('cancelled');

            $this->profileRepository->save($profile);
        }

        return $cart;
    }
}