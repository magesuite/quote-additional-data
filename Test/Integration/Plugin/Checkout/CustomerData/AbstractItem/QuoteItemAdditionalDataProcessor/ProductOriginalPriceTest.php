<?php

namespace MageSuite\QuoteAdditionalData\Test\Integration\Model\Checkout\CustomerData\QuoteItemAdditionalDataProcessor;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class ProductOriginalPriceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Checkout\CustomerData\Cart
     */
    protected $cartCustomerData;

    /**
     * @var \MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteItemAdditionalDataProcessor\ProductOriginalPrice
     */
    protected $additionalDataProcessor;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->cartCustomerData = $this->objectManager->get(\Magento\Checkout\CustomerData\Cart::class);
        $this->additionalDataProcessor = $this->objectManager->get(\MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteItemAdditionalDataProcessor\ProductOriginalPrice::class);
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_product.php
     */
    public function testProductOriginalPriceWithoutSpecialPrice()
    {
        if (!$this->additionalDataProcessor->isEnabled()) {
            $this->markTestSkipped('AdditionalDataProcessor is disabled.');
        }

        $data = $this->cartCustomerData->getSectionData();
        $this->assertNull($data['items'][0]['product_original_price']);
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_special_price_product.php
     */
    public function testProductOriginalPriceWithSpecialPrice()
    {
        if (!$this->additionalDataProcessor->isEnabled()) {
            $this->markTestSkipped('AdditionalDataProcessor is disabled.');
        }

        $expectedProductOriginalPrice = '<span class="price">$10.00</span>';

        $data = $this->cartCustomerData->getSectionData();
        $this->assertEquals($expectedProductOriginalPrice, $data['items'][0]['product_original_price']);
    }
}
