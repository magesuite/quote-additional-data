<?php

namespace MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor;

class RowTotalProductPrice implements \MageSuite\QuoteAdditionalData\Api\QuoteAdditionalDataProcessorInterface
{
    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    public function __construct(\Magento\Checkout\Helper\Data $checkoutHelper)
    {
        $this->checkoutHelper = $checkoutHelper;
    }

    public function execute(array $sectionData)
    {
        if (!is_array($sectionData['items'])) {
            return $sectionData;
        }

        foreach ($sectionData['items'] as $key => $item) {
            $rowTotalProductPriceValue = (float)$item['product_price_value'] * (float)$item['qty'];
            $sectionData['items'][$key]['row_total_product_price_value'] = $rowTotalProductPriceValue;
            $sectionData['items'][$key]['row_total_product_price'] = $this->checkoutHelper->formatPrice($rowTotalProductPriceValue);

            $rowTotalProductOriginalPriceValue = $item['product_original_price_value'] ? (float)$item['product_original_price_value'] * (float)$item['qty'] : null;
            $sectionData['items'][$key]['row_total_product_original_price'] = $rowTotalProductOriginalPriceValue ? $this->checkoutHelper->formatPrice($rowTotalProductOriginalPriceValue) : null;
            $sectionData['items'][$key]['row_total_product_original_price_value'] = $rowTotalProductOriginalPriceValue;
        }

        return $sectionData;
    }
}
