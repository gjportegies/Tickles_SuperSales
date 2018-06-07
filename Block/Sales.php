<?php

namespace Tickles\Supersales\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data;
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
     * @var array
     */
    private $priceHelper;

    /**
     * Sales constructor.
     *
     * @param Context                                $context
     * @param SaleFactory                            $saleFactory
     * @param ProductRepositoryInterface             $productRepository
     * @param LoggerInterface                        $logger
     * @param ImageBuilder                           $imageBuilder
     * @param Data $priceHelper
     * @param array                                  $data
     */
    public function __construct(
        Context $context,
        SaleFactory $saleFactory,
        ProductRepositoryInterface $productRepository,
        LoggerInterface $logger,
        ImageBuilder $imageBuilder,
        Data $priceHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->saleFactory = $saleFactory;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        $this->imageBuilder = $imageBuilder;
        $this->priceHelper = $priceHelper;
    }

    public function getImage($product, $imageId)
    {
        return $this->imageBuilder->setProduct($product)
                                  ->setImageId($imageId)
                                  ->create();
    }

    public function getFormattedPrice($price, $format = true, $includeContainer = true)
    {
        return $this->priceHelper->currency($price, $format, $includeContainer);
    }

    /**
     * @param null $pageSize
     *
     * @return array
     */
    public function getActiveSalesProducts($pageSize = null) {

        $saleIdentifier = $this->getData('sale_identifier') ?? null;
        $sales = $this->getSuperSalesCollection($saleIdentifier, $pageSize);

        $salesProductsArray = [];
        foreach ($sales->getItems() as $sale) {
            $productId = $sale->getData('product_id');
            try {
                if ($sale->getData('is_enabled')) {
                    $product = $this->productRepository->getById($productId);
                    $product->setData('end_date', $sale->getData('end_date'));
                    $product->setData('start_date', $sale->getData('start_date'));
                    $product->setData('label_text', $sale->getData('label_text'));
                    $salesProductsArray[] = $product;
                }
            } catch (NoSuchEntityException $e) {
                $this->logger->critical($e);
            }
        }

        return $salesProductsArray;
    }

    /**
     * Get super sales collection
     *
     * @param      $saleIdentifier optional parameter to get specific supersale
     *
     * @param null $pageSize optional parameter to set amount of results in the collection
     *
     * @return array [\Tickles\Supersales\Model\ResourceModel\Sale\Collection]
     */
    public function getSuperSalesCollection($saleIdentifier = null, $pageSize = null)
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');

        $sales = $this->saleFactory
            ->create()
            ->getCollection()
            ->addFieldToFilter('start_date', ['lteq' => $now])
            ->addFieldToFilter('end_date', ['gt' => $now])
            ->addFieldToFilter('is_enabled', true);
        if($saleIdentifier !== null) {
            $sales->addFieldToFilter('sale_identifier', $saleIdentifier);
            if ($pageSize !== null){
                $sales->setPageSize($pageSize);
            }
        }

        return $sales;
    }

}