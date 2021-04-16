<?php

namespace Aht\Product\Api\Data;

interface ProductInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                    = 'id';
    const NAME                  = 'name';
    const IMAGE                 = 'image';
    const PRICE                 = 'price';
    const DESCRIPTION           = 'description';
    const FEATURED              = 'featured';
    const CATEGORY_ID           = 'category_id';
    const CREATED_AT            = 'created_at';
    /**#@-*/

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Get Price
     *
     * @return float|null
     */
    public function getPrice();

    /**
     * Get Description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get Featured
     *
     * @return string|null
     */
    public function getFeatured();

    /**
     * Get CategoryId
     *
     * @return string|null
     */
    public function getCategoryId();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Set Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Set Price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * Set Description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Set Featured
     *
     * @param string $featured
     * @return $this
     */
    public function setFeatured($featured);

    /**
     * Set CategoryId
     *
     * @param string $category_id
     * @return $this
     */
    public function setCategoryId($category_id);

    /**
     * Set Crated At
     *
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);
}
