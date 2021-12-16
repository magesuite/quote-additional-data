<?php

namespace MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteItemAdditionalDataProcessor;

class ProductOriginalPrice implements \MageSuite\QuoteAdditionalData\Api\QuoteItemAdditionalDataProcessorInterface
{
    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    /**
     * @var \Magento\Tax\Block\Item\Price\Renderer
     */
    protected $itemPriceRenderer;

    public function __construct(
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Tax\Block\Item\Price\Renderer $itemPriceRenderer
    ) {
        $this->checkoutHelper = $checkoutHelper;
        $this->itemPriceRenderer = $itemPriceRenderer;
    }

    public function execute(\Magento\Quote\Model\Quote\Item $item, array $itemData)
    {
        $additionalData = [];

        $product = $item->getProduct();
        if (!$product instanceof \Magento\Catalog\Api\Data\ProductInterface) {
            return $additionalData;
        }

        $productOriginalPrice = $this->getOriginalPrice($product, $item);

        $additionalData['product_original_price'] = $productOriginalPrice ? $this->checkoutHelper->formatPrice($productOriginalPrice) : null;
        $additionalData['product_original_price_value'] = $productOriginalPrice;

        return $additionalData;
    }

    protected function getOriginalPrice(\Magento\Catalog\Api\Data\ProductInterface $product, \Magento\Quote\Model\Quote\Item $item)
    {
        $productPrice = $this->getItemProduct($product, $item)
            ->getPriceInfo()
            ->getPrice(\Magento\Catalog\Pricing\Price\RegularPrice::PRICE_CODE)
            ->getAmount()
            ->getValue();

        if ($productPrice != 0 && $productPrice == number_format($item->getBasePriceInclTax(), 2)) {
            return null;
        }

        if ($this->itemPriceRenderer->displayPriceExclTax()) {
            return $product->getPriceInfo()
                ->getPrice(\Magento\Catalog\Pricing\Price\RegularPrice::PRICE_CODE)
                ->getAmount()
                ->getBaseAmount();
        } elseif ($this->itemPriceRenderer->displayPriceInclTax()) {
            return $productPrice;
        }

        return null;
    }

    protected function getItemProduct(\Magento\Catalog\Model\Product $product, \Magento\Quote\Model\Quote\Item $item)
    {
        if ($product->getTypeId() != \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            return $product;
        }

        $itemChild = current($item->getChildren());

        return $itemChild->getProduct();
    }
}
