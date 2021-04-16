<?php

namespace Aht\Product\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Aht\Product\Model\ResourceModel\Product\Grid\CollectionFactory;
use Aht\Product\Helper\Data;

class Product extends Template implements BlockInterface
{
    protected $_collection;
    public $_storeManager;
    public $_customerSession;
    public $_helperData;

    const DEFAULT_PRODUCTS_PER_PAGE = 5;

    public function __construct(
        CollectionFactory $blogCollectionFactory,
        Context $context,
        Session $customerSession,
        Data $helperData,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_customerSession = $customerSession;
        $this->_helperData = $helperData;
        $this->_collection =  $blogCollectionFactory->create();
    }

    public function getProductWidget($name, $value)
    {
        if (!$this->hasData($name)) {
            $this->setData($name, $value);
        }
        return $this->getData($name);
    }

    public function getDataBlocks()
    {
        $data = $this->_collection->getData();
        return $data;
    }

    public function getStoreManager()
    {
        return $this->_storeManager;
    }

    public function getUrlImagePrd($imageUrl, $field)
    {
        return $this->_storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'product/index/' . $imageUrl[$field];
    }
}
