<?php

namespace Tickles\Supersales\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Psr\Log\LoggerInterface;
use Tickles\Supersales\Model\SaleFactory;

class Sales extends Template
{

    private $saleFactory;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Sales constructor.
     *
     * @param Context                    $context
     * @param SaleFactory                $saleFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(Context $context, SaleFactory $saleFactory, ProductRepositoryInterface $productRepository, LoggerInterface $logger)
    {
        parent::__construct($context);
        $this->saleFactory = $saleFactory;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    public function getActiveSalesProducts() {
        $sales = $this->saleFactory->create()->getCollection()->setOrder('sort_order', 'asc');
        $salesProductsArray = [];
        foreach ($sales as $sale) {
            $productId = $sale->getData('product_id');
            try {
                if ($sale->getData('is_enabled')) {
                    $product = $this->productRepository->getById($productId);
                    $salesProductsArray[] = $product;
                }
            } catch (NoSuchEntityException $e) {
                $this->logger->critical($e);
                die($e);
            }
        }
        return $salesProductsArray;
    }
}