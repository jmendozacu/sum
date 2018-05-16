<?php

namespace Eleanorsoft\AheadworksSarp\Controller\Product;

use Eleanorsoft\AheadworksSarp\Controller\AbstractInfo;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Url;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;


/**
 * Class ProductList
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class ProductList extends AbstractInfo
{
    /**
     * @var SearchCriteriaInterface
     */
    protected $searchCriteria;

    /**
     * @var FilterGroup
     */
    protected $filterGroup;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var Visibility
     */
    protected $visibility;

    /**
     * ProductList constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param Url $productUrl
     * @param Json $json
     * @param SearchCriteriaInterface $searchCriteria
     * @param FilterGroup $filterGroup
     * @param FilterBuilder $filterBuilder
     * @param Status $status
     * @param Visibility $visibility
     */
    public function __construct
    (
        Context $context,
        ProductRepositoryInterface $productRepository,
        Url $productUrl,
        Json $json,
        SearchCriteriaInterface $searchCriteria,
        FilterGroup $filterGroup,
        FilterBuilder $filterBuilder,
        Status $status,
        Visibility $visibility
    )
    {
        parent::__construct($context, $productRepository, $productUrl, $json);
        $this->searchCriteria = $searchCriteria;
        $this->filterGroup = $filterGroup;
        $this->filterBuilder = $filterBuilder;
        $this->status = $status;
        $this->visibility = $visibility;
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @return ProductInterface[]
     */
    protected function getProductData()
    {

        $this->filterGroup->setFilters([
            $this->filterBuilder
                ->setField('status')
                ->setConditionType('in')
                ->setValue($this->status->getVisibleStatusIds())
                ->create(),
            $this->filterBuilder
                ->setField('visibility')
                ->setConditionType('in')
                ->setValue($this->visibility->getVisibleInSiteIds())
                ->create(),
        ]);

        $this->searchCriteria->setFilterGroups([$this->filterGroup]);
        $products = $this->productRepository->getList($this->searchCriteria);
        $productItems = $products->getItems();

        return $productItems;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $productItems = $this->getProductData();
        $productData = [];

        foreach ($productItems as $item) { /** @var ProductInterface $item */
            $productData[] = [
                'id' => $item->getId(),
                'name' => $item->getName()
            ];
        }

        return $this->json->setData($productData);
    }
}