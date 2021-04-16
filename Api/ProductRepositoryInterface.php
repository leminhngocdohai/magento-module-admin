<?php

namespace Aht\Product\Api;

use Aht\Product\Api\Data\ProductInterface;

interface ProductRepositoryInterface
{
    /**
     * Save Product.
     *
     * @param ProductInterface $product
     * 
     * @return ProductInterface
     */
    public function save(ProductInterface $product);

    /**
     * Get object by id
     *
     * @return ProductInterface
     */
    public function getById(String $id);

    /**
     * Get All
     * 
     * @return ProductInterface
     */
    public function getList();

    /**
     * Create Product.
     *
     * @param ProductInterface $product
     * 
     * @return ProductInterface
     */
    public function createProduct(ProductInterface $product);

    /**
     * Update Product
     *
     * @param String $id
     * @param ProductInterface $product
     * 
     * @return null
     */
    public function updateProduct(String $id, ProductInterface $product);

    /**
     * Delete Product by ID.
     *
     * @param string $productId
     * @return \Aht\Product\Api\Data\PostInterface
     */
    public function deleteById($productId);
}
