<?php
namespace Aht\Product\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_PRODUCT = 'product/';

    public function getConfigValue($field)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE
        );
    }

    public function getSlideConfig($code)
    {
        return $this->getConfigValue(self::XML_PATH_PRODUCT .'slide/'. $code);
    }

    public function getProductConfig($code)
    {
        return $this->getConfigValue(self::XML_PATH_PRODUCT .'product/'. $code);
    }

}
