<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Aht\Product\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Aht\Product\Api\ProductRepositoryInterface;
use Aht\Product\Model\ProductFactory;
use Aht\Product\Model\Product\ImageUploader;
use Magento\Framework\Filesystem\Driver\File;
use Aht\Product\Controller\Adminhtml\Product;

/**
 * Save CMS block action.
 */
class Save extends Product implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var BlockFactory
     */
    private $blockFactory;
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;
    /**
     * @var ImageUploader
     */
    protected $imageUploader;
    protected $_file;

    protected $_dir;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param BlockFactory|null $blockFactory
     * @param BlockRepositoryInterface|null $blockRepository
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ProductFactory $blockFactory = null,
        ImageUploader $imageUploader,
        ProductRepositoryInterface $blockRepository = null,
        File $file,
        \Magento\Framework\Filesystem\DirectoryList $dir
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->blockFactory = $blockFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ProductFactory::class);
        $this->blockRepository = $blockRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ProductRepositoryInterface::class);
        $this->imageUploader = $imageUploader;
        $this->_file = $file;
        $this->_dir = $dir;
        parent::__construct($context, $coreRegistry);
    }
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** get dir file */
        $mediaDirectory = $this->_dir->getPath('media');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            /** @var \Magento\Cms\Model\Block $model */
            $model = $this->blockFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->blockRepository->getById($id);
                    //delete Image
                    $pathImg = $mediaDirectory . "/product/index/" . $model->load($id)->getImage();
                    if ($this->_file->isExists($pathImg)) {
                        ($model->load($id)->getImage() == 'no-img.png') ?: $this->_file->deleteFile($pathImg);
                    }
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            /*save data image */
            (isset($data['image'][0]['name'])) ? $imageName = $data['image'][0]['name'] : $imageName = 'no-img.png';

            $data['image'] = $imageName;

            $model->setData($data);
            try {
                $this->blockRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the product.'));
                $this->dataPersistor->clear('product');
                if ($imageName) {
                    $this->imageUploader->moveFileFromTmp($imageName);
                }
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the product.'));
            }
            $this->dataPersistor->set('product', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param \Magento\Cms\Model\Block $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';
        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } else if ($redirect === 'duplicate') {
            $duplicateModel = $this->blockFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel->setIdentifier($data['identifier'] . '-' . uniqid());
            $duplicateModel->setIsActive(Block::STATUS_DISABLED);
            $this->blockRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the block.'));
            $this->dataPersistor->set('post', $data);
            $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect;
    }
}
