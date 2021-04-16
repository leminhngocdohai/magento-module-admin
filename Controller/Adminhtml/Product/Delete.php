<?php
namespace Aht\Product\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\Driver\File;

class Delete extends \Magento\Backend\App\Action
{
    protected $storeManager;
    protected $imageUploader;
    protected $_file;

    public function __construct(
        Context $context,
        File $file
    ) {
        $this->_file = $file;
        parent::__construct($context);
    }

    /**
     * Delete Banner
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $bannerId = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($bannerId && (int) $bannerId > 0) {
            try {
                $model = $this->_objectManager->create('Aht\Product\Model\Product');
                $model->load($bannerId);

                //delete Image
                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                $mediaRootDir = $mediaDirectory->getAbsolutePath();

                $pathImg = $mediaRootDir . "product/index/" . $model->load($bannerId)->getImage();
                if ($this->_file->isExists($pathImg)) {
                    ($model->load($bannerId)->getImage() == 'no-img.png') ?: $this->_file->deleteFile($pathImg);
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
