<?php

namespace MageSuite\QuoteAdditionalData\Test\Integration\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class RowTotalProductPriceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Checkout\CustomerData\Cart
     */
    protected $cartCustomerData;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->cartCustomerData = $this->objectManager->get(\Magento\Checkout\CustomerData\Cart::class);
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_product.php
     */
    public function testRowTotalPriceWithoutSpecialPrice()
    {
        $expectedRowTotalProductPrice = '<span class="price">$20.00</span>';

        $data = $this->cartCustomerData->getSectionData();
        $this->assertEquals($expectedRowTotalProductPrice, $data['items'][0]['row_total_product_price']);
        $this->assertNull($data['items'][0]['row_total_product_original_price']);
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_special_price_product.php
     */
    public function testRowTotalPriceWithSpecialPrice()
    {
        $expectedRowTotalProductPrice = '<span class="price">$10.00</span>';
        $expectedRowTotalProductOriginalPrice = '<span class="price">$20.00</span>';

        $data = $this->cartCustomerData->getSectionData();
        $this->assertEquals($expectedRowTotalProductPrice, $data['items'][0]['row_total_product_price']);
        $this->assertEquals($expectedRowTotalProductOriginalPrice, $data['items'][0]['row_total_product_original_price']);
    }
}
