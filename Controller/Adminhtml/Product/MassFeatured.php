<?php
namespace Aht\Product\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Aht\Product\Model\ResourceModel\Product\CollectionFactory; // Define your collection here
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDisable
 */
class MassFeatured extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $featuredValue = $this->getRequest()->getParam('featured');
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setFeatured($featuredValue);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('product/product/index');
    }
}
