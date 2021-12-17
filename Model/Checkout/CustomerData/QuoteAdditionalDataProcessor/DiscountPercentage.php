<?php

namespace MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor;

class DiscountPercentage implements \MageSuite\QuoteAdditionalData\Api\QuoteAdditionalDataProcessorInterface
{
    /**
     * @var bool
     */
    protected $isEnabled;

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
            if (empty($item['product_original_price_value'] || $item['product_original_price_value'] == $item['product_price_value'])) {
                $sectionData['items'][$key]['discount_percentage'] = null;
                continue;
            }

            $discountPercentage = round((($item['product_original_price_value'] - $item['product_price_value']) / $item['product_original_price_value']) * 100, 0);
            $sectionData['items'][$key]['discount_percentage'] = $discountPercentage;
        }

        return $sectionData;
    }
}
