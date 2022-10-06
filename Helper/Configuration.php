<?php

namespace MageSuite\QuoteAdditionalData\Helper;

class Configuration
{
    const XML_PATH_QUOTE_ADDITIONAL_DATA_IS_ENABLED = 'quote_additional_data/general/is_enabled';

    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_QUOTE_ADDITIONAL_DATA_IS_ENABLED);
    }
}
