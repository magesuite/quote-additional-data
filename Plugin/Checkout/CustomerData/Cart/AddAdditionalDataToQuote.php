<?php

namespace MageSuite\QuoteAdditionalData\Plugin\Checkout\CustomerData\Cart;

class AddAdditionalDataToQuote
{
    protected \MageSuite\QuoteAdditionalData\Helper\Configuration $configuration;

    protected array $additionalDataProcessors;

    public function __construct(
        \MageSuite\QuoteAdditionalData\Helper\Configuration $configuration,
        array $additionalDataProcessors
    ) {
        $this->configuration = $configuration;
        $this->additionalDataProcessors = $additionalDataProcessors;
    }

    public function afterGetSectionData(\Magento\Checkout\CustomerData\Cart $subject, $result)
    {
        if (!$this->configuration->isEnabled()) {
            return $result;
        }

        foreach ($this->additionalDataProcessors as $additionalDataProcessor) {
            if (!$additionalDataProcessor instanceof \MageSuite\QuoteAdditionalData\Api\QuoteAdditionalDataProcessorInterface) {
                continue;
            }

            if (!$additionalDataProcessor->isEnabled()) {
                continue;
            }

            $result = $additionalDataProcessor->execute($result);
        }

        return $result;
    }
}
