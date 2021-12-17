<?php

namespace MageSuite\QuoteAdditionalData\Api;

interface QuoteItemAdditionalDataProcessorInterface
{
    public function isEnabled(): bool;

    public function execute(\Magento\Quote\Model\Quote\Item $item, array $itemData): array;
}
