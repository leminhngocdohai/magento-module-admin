<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aht\Product\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Aht\Product\Controller\Adminhtml\Product;
use Aht\Product\Model\ProductFactory;

class Edit extends Product implements HttpGetActionInterface
{
    protected $resultPageFactory;
    protected $_productFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ProductFactory $productFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
        $this->_productFactory = $productFactory;
    }

    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_productFactory->create();

        // Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('product', $model);
        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Product') : __('New Product'),
            $id ? __('Edit Product') : __('New Product')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('All Product'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('Edit Product'));
        return $resultPage;
    }
}
