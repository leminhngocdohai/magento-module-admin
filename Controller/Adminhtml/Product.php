<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Aht\Product\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

abstract class Product extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;

    public function __construct(Context $context, Registry $coreRegistry)
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Aht_Item::index_product');
        return $resultPage;
    }
}
