<?php

namespace Tickles\Supersales\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tickles\Supersales\Model\SaleFactory;

class Sales extends Template
{

    private $saleFactory;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Sales constructor.
     *
     * @param Context                    $context
     * @param SaleFactory                $saleFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(Context $context, SaleFactory $saleFactory, ProductRepositoryInterface $productRepository)
    {
        parent::__construct($context);
        $this->saleFactory = $saleFactory;
        $this->productRepository = $productRepository;
    }

    public function getActiveSales() {
        $sales = $this->saleFactory->create()->getCollection();
        $salesProductsArray = [];

        foreach ($sales as $sale) {
            $productId = $sale->getData('product_id');

            try {
                $product = $this->productRepository->getById($productId)->getName();
                $salesProductsArray[] = array_push($salesProductsArray, $product);
            } catch (NoSuchEntityException $e) {
                die($e);
            }
        }

        return $salesProductsArray;
    }
}