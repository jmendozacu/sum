<?php

namespace Eleanorsoft\AheadworksSarp\Controller;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Url;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;


/**
 * Class AbstractInfo
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

abstract class AbstractInfo extends Action
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Url
     */
    protected $productUrl;

    /**
     * @var
     */
    protected $json;

    /**
     * AbstractInfo constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param Url $productUrl
     * @param Json $json
     */
    public function __construct
    (
        Context $context,
        ProductRepositoryInterface $productRepository,
        Url $productUrl,
        Json $json
    )
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->productUrl = $productUrl;
        $this->json = $json;
    }
}