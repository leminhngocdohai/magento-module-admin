<?php
namespace Aht\Product\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\Driver\File;
use Aht\Product\Model\ProductFactory;

class Delete extends \Magento\Backend\App\Action
{
    protected $storeManager;
    protected $imageUploader;
    protected $_file;
    protected $_product;
    protected $_dir;

    public function __construct(
        Context $context,
        File $file,
        ProductFactory $product,
        \Magento\Framework\Filesystem\DirectoryList $dir
    ) {
        $this->_file = $file;
        $this->_product = $product;
        parent::__construct($context);
        $this->_dir = $dir;
    }

    /**
     * Delete Banner
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id && (int) $id > 0) {
            try {
                $model = $this->_product->create()->load($id);
                //delete Image
                $mediaDirectory = $this->_dir->getPath('media');
                $pathImg = $mediaDirectory . "/product/index/" . $model->getImage();
                if ($this->_file->isExists($pathImg)) {
                    ($model->getImage() == 'no-img.png') ?: $this->_file->deleteFile($pathImg);
                }
                //delete Model
                $model->delete();
                $this->messageManager->addSuccess(__('Xóa sản phẩm thành công !'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/index');
            }
        }
        $this->messageManager->addError(__('Product doesn\'t exist any longer.'));
        return $resultRedirect->setPath('*/*/index');
    }
}
