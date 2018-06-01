<?php

namespace Tickles\Supersales\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\DataObject;
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
     * @var ImageBuilder
     */
    private $imageBuilder;

    /**
     * Sales constructor.
     *
     * @param Context                    $context
     * @param SaleFactory                $saleFactory
     * @param ProductRepositoryInterface $productRepository
     * @param LoggerInterface            $logger
     * @param ImageBuilder               $imageBuilder
     * @param array                      $data
     */
    public function __construct(Context $context, SaleFactory $saleFactory, ProductRepositoryInterface $productRepository, LoggerInterface $logger, ImageBuilder $imageBuilder, array $data = [])
    {
        parent::__construct($context, $data);
        $this->saleFactory = $saleFactory;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        $this->imageBuilder = $imageBuilder;
    }

    public function getImage($product, $imageId)
    {
        return $this->imageBuilder->setProduct($product)
                                  ->setImageId($imageId)
                                  ->create();
    }


    public function getActiveSalesProducts() {
        // TODO - CHECK CURRENT DATETIME AGAINST START/END DATES OF THE SALE IN ADDITION TO IS_ENABLED

        if (!$this->getData('supersales_id')) {
            $sales = $this->saleFactory->create()->getCollection()->setOrder('sort_order', 'asc');
        } else {
            $supersalesId = $this->getData('supersales_id');
            $superSale = $this->saleFactory->create()->getCollection()->getItemById($supersalesId);

            if(empty($superSale)) {
                return [];
            }

            $sales = [$superSale];
        }

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
            }
        }

        return $salesProductsArray;
    }
}