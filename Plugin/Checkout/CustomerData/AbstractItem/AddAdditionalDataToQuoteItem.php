<?php

namespace MageSuite\QuoteAdditionalData\Plugin\Checkout\CustomerData\AbstractItem;

class AddAdditionalDataToQuoteItem
{
    /**
     * @var \MageSuite\QuoteAdditionalData\Helper\Configuration
     */
    protected $configuration;

    /**
     * @var array
     */
    protected $additionalDataProcessors;

    public function __construct(
        \MageSuite\QuoteAdditionalData\Helper\Configuration $configuration,
        array $additionalDataProcessors
    ) {
        $this->configuration = $configuration;
        $this->additionalDataProcessors = $additionalDataProcessors;
    }

    public function afterGetItemData(\Magento\Checkout\CustomerData\AbstractItem $subject, array $result, \Magento\Quote\Model\Quote\Item $item)
    {
        if (!$this->configuration->isEnabled()) {
            return $result;
        }

        $additionalDataItems = [];
        foreach ($this->additionalDataProcessors as $additionalDataProcessor) {
            if (!$additionalDataProcessor instanceof \MageSuite\QuoteAdditionalData\Api\QuoteItemAdditionalDataProcessorInterface) {
                continue;
            }

            if (!$additionalDataProcessor->isEnabled()) {
                continue;
            }

            $additionalDataItems[] = $additionalDataProcessor->execute($item, $result);
        }

        return array_merge($result, ...$additionalDataItems);
    }
}
