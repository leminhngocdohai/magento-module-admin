<?php

namespace Aht\Product\Model;

use Aht\Product\Api\Data\ProductInterfaceFactory;
use Aht\Product\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Aht\Product\Model\ResourceModel\Product as ResourceProduct;
use Aht\Product\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Aht\Product\Api\Data\ProductInterface;

/**
 * Class ProductRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ProductRepository implements ProductRepositoryInterface
{

    protected $resource;
    protected $productFactory;
    protected $productCollectionFactory;
    protected $searchResultsFactory;
    private $collectionProcessor;

    public function __construct(
        ResourceProduct $resource,
        ProductFactory $productFactory,
        ProductInterfaceFactory $dataProductFactory,
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->resource = $resource;
        $this->ProductFactory = $productFactory;
        $this->ProductCollectionFactory = $productCollectionFactory;
    }

    /**
     * Save Product data
     *
     * @param  ProductInterface $product
     * @return ProductInterface
     */
    public function save(ProductInterface $product)
    {
        try {
            $this->resource->save($product);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the Product: %1', $exception->getMessage()),
                $exception
            );
        }
        return $product;
    }

    /**
     * Load Product data by given Product Identity
     *
     * @param [type] $id
     * @return \Aht\Product\Model\ResourceModel\Product
     */
    public function getById($id)
    {
        $productId = intval($id);
        $product = $this->ProductFactory->create();
        $product->load($productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('The CMS Product with the "%1" ID doesn\'t exist.'));
        }
        $result = $product;
        return $result;
    }

    /**
     * function get all data
     *
     * @return ProductInterface
     */
    public function getList()
    {
        $collection = $this->ProductCollectionFactory->create();
        return $collection->getData();
    }

    /**
     * Create Product.
     *  
     * @return ProductInterface
     * 
     * @throws LocalizedException
     */
    public function createProduct(ProductInterface $product)
    {
        try {
            $this->resource->save($product);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the Product: %1', $exception->getMessage()),
                $exception
            );
        }
        return json_encode(array(
            "status" => 200,
            "message" => $product->getData()
        ));
    }

    public function updateProduct(String $id, ProductInterface $product)
    {
        try {
            $objProduct = $this->ProductFactory->create();
            $id = intval($id);
            $objProduct->setId($id);
            //Set full collum
            $objProduct->setData($product->getData());
            $this->resource->save($objProduct);

            return $objProduct->getData();
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the Product: %1', $exception->getMessage()),
                $exception
            );
        }
    }

    public function deleteById($productId)
    {
        $id = intval($productId);
        if ($this->resource->delete($this->getById($id))) {
            return json_encode([
                "status" => 200,
                "message" => "Successfully"
            ]);
        }
    }
}
