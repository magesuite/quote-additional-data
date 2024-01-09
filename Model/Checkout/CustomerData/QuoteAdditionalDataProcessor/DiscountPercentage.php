<?php

namespace MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor;

class DiscountPercentage implements \MageSuite\QuoteAdditionalData\Api\QuoteAdditionalDataProcessorInterface
{
    protected bool $isEnabled;

    public function __construct($isEnabled = true)
    {
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
            if (empty($item['product_original_price_value']) || $item['product_original_price_value'] == $item['product_price_value']) {
                $sectionData['items'][$key]['discount_percentage'] = null;
                continue;
            }

            $sectionData['items'][$key]['discount_percentage'] = $this->calculateDiscountPercentage($item);
        }

        return $sectionData;
    }

    public function calculateDiscountPercentage(array $itemData): int
    {
        $regularPrice = $itemData['product_original_price_value'];
        $finalPrice = $itemData['product_price_value'];

        return round((($regularPrice - $finalPrice) / $regularPrice) * 100);
    }
}
