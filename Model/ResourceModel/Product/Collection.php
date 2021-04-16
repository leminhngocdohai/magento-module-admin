<?php
namespace Aht\Product\Model\ResourceModel\Product;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Remittance File Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\Product\Model\Product', 'Aht\Product\Model\ResourceModel\Product');
    }
}