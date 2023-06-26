<?php

namespace MageSuite\QuoteAdditionalData\Test\Integration\Model\Checkout\CustomerData\Cart\QuoteAdditionalDataProcessor;

/**
 * @magentoAppArea frontend
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class RowTotalProductPriceTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\Magento\Checkout\CustomerData\Cart $cartCustomerData;

    protected ?\MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor\RowTotalProductPrice $additionalDataProcessor;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->cartCustomerData = $this->objectManager->get(\Magento\Checkout\CustomerData\Cart::class);
        $this->additionalDataProcessor = $this->objectManager->get(\MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor\RowTotalProductPrice::class);
    }

    /**
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_product.php
     */
    public function testRowTotalPriceWithoutSpecialPrice()
    {
        if (!$this->additionalDataProcessor->isEnabled()) {
            $this->markTestSkipped('AdditionalDataProcessor is disabled.');
        }

        $expectedRowTotalProductPrice = '<span class="price">$20.00</span>';

        $data = $this->cartCustomerData->getSectionData();
        $this->assertEquals($expectedRowTotalProductPrice, $data['items'][0]['row_total_product_price']);
        $this->assertNull($data['items'][0]['row_total_product_original_price']);
    }

    /**
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_special_price_product.php
     */
    public function testRowTotalPriceWithSpecialPrice()
    {
        if (!$this->additionalDataProcessor->isEnabled()) {
            $this->markTestSkipped('AdditionalDataProcessor is disabled.');
        }

        $expectedRowTotalProductPrice = '<span class="price">$10.00</span>';
        $expectedRowTotalProductOriginalPrice = '<span class="price">$20.00</span>';

        $data = $this->cartCustomerData->getSectionData();
        $this->assertEquals($expectedRowTotalProductPrice, $data['items'][0]['row_total_product_price']);
        $this->assertEquals($expectedRowTotalProductOriginalPrice, $data['items'][0]['row_total_product_original_price']);
    }
}
