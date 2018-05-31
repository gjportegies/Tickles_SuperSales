<?php

namespace Tickles\Supersales\Model\ResourceModel\Sale;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'supersale_id';


    protected function _construct()
    {
        $this->_init('Tickles\Supersales\Model\Sale', 'Tickles\Supersales\Model\ResourceModel\Sale');
    }

}