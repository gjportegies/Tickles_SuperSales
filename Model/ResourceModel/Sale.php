<?php

namespace Tickles\Supersales\Model\ResourceModel;

class Sale extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('supersale', 'supersale_id');
    }

}