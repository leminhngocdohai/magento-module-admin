<?php

namespace Aht\Product\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Aht\Product\Api\Data\ProductInterface;

/**
 * Class File
 * @package Aht\Product\Model
 * implements ProductInterface, IdentityInterface
 */

class Product extends AbstractModel implements IdentityInterface, ProductInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'aht_product_items';

    /**
     * Product Initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\Product\Model\ResourceModel\Product');
    }

    /**
     * Return identities
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Get Price
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * Get Description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Get Featured
     *
     * @return int|null
     */
    public function getFeatured()
    {
        return $this->getData(self::FEATURED);
    }

    /**
     * Get Category Id
     *
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Set Price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Set Featured
     *
     * @param string $featured
     * @return $this
     */
    public function setFeatured($featured)
    {
        return $this->setData(self::FEATURED, $featured);
    }

    /**
     * Set CategoryId
     *
     * @param string $category_id
     * @return $this
     */
    public function setCategoryId($category_id)
    {
        return $this->setData(self::CATEGORY_ID, $category_id);
    }

    /**
     * Set Created At
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
}
