<?php


namespace Tickles\Supersales\Config\Model\Config\Source;


use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Tickles\Supersales\Model\Sale;
use Tickles\Supersales\Model\SaleFactory;

class Sales extends AbstractSource
{


    /**
     * @var SaleFactory
     */
    private $saleFactory;

    public function __construct(SaleFactory $saleFactory)
    {

        $this->saleFactory = $saleFactory;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        $optionArray = [];
        $sales = $this->saleFactory->create()->getCollection();
        /** @var Sale $sale */
        foreach ($sales as $sale) {
            $optionArray[] = ['value' => $sale->getId(), 'label' => $sale->getName()];
        }

        return $optionArray;

    }

    public function getAllOptions(): array
    {
        return $this->toOptionArray();
    }
}