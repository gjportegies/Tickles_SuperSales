<?php

namespace Tickles\Supersales\Model;

/**
 * @method \Tickles\Supersales\Model\ResourceModel\Sale getResource()
 * @method \Tickles\Supersales\Model\ResourceModel\Sale\Collection getCollection()
 */
class Sale extends \Magento\Framework\Model\AbstractModel implements \Tickles\Supersales\Api\Data\SaleInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'tickles_supersales_sale';
    protected $_cacheTag = 'tickles_supersales_sale';
    protected $_eventPrefix = 'tickles_supersales_sale';

    protected function _construct()
    {
        $this->_init('Tickles\Supersales\Model\ResourceModel\Sale');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}