<?php

namespace Aht\Product\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Product extends AbstractDb
{
    /**
     * Product Abstract Resource Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('aht_product_items', 'id');
    }
}