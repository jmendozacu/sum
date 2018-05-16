<?php

namespace Eleanorsoft\AheadworksSarp\Controller\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;


/**
 * Class SaveProduct
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class SaveProduct extends Action
{

    protected $productRepository;


    public function __construct
    (
        Context $context,
        ProductRepositoryInterface $productRepository
    )
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $response_json = file_get_contents("php://input");
        $da = json_decode($response_json);

        $t = '';
    }
}