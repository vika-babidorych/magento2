<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Helper;

/**
 * Class Data
 *
 * Helper Data
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Function getConfig
     *
     * @param string $config_path
     * @return mixed
     */
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
