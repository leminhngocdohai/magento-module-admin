<?php

namespace Aht\Product\Controller\Product;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Detail extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $this->_coreRegistry->register('editRecordId', $id);
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
