<?php

namespace MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor;

class RowTotalProductPrice implements \MageSuite\QuoteAdditionalData\Api\QuoteAdditionalDataProcessorInterface
{
    protected bool $isEnabled;

    protected \Magento\Checkout\Helper\Data $checkoutHelper;

    public function __construct(
        \Magento\Checkout\Helper\Data $checkoutHelper,
        $isEnabled = true
    ) {
        $this->checkoutHelper = $checkoutHelper;

        $this->isEnabled = $isEnabled;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function execute(array $sectionData): array
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
