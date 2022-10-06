<?php

namespace MageSuite\QuoteAdditionalData\Test\Integration\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor;

/**
 * @magentoAppArea frontend
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class DiscountPercentageTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\Magento\Checkout\CustomerData\Cart $cartCustomerData;

    protected ?\MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor\DiscountPercentage $additionalDataProcessor;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->cartCustomerData = $this->objectManager->get(\Magento\Checkout\CustomerData\Cart::class);
        $this->additionalDataProcessor = $this->objectManager->get(\MageSuite\QuoteAdditionalData\Model\Checkout\CustomerData\QuoteAdditionalDataProcessor\DiscountPercentage::class);
    }

    /**
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_product.php
     */
    public function testDiscountPercentWithoutSpecialPrice()
    {
        if (!$this->additionalDataProcessor->isEnabled()) {
            $this->markTestSkipped('AdditionalDataProcessor is disabled.');
        }

        $data = $this->cartCustomerData->getSectionData();
        $this->assertNull($data['items'][0]['discount_percentage']);
    }

    /**
     * @magentoConfigFixture default/quote_additional_data/general/is_enabled 1
     * @magentoDataFixture MageSuite_QuoteAdditionalData::Test/Integration/_files/quote_with_special_price_product.php
     */
    public function testDiscountPercentWithSpecialPrice()
    {
        if (!$this->additionalDataProcessor->isEnabled()) {
            $this->markTestSkipped('AdditionalDataProcessor is disabled.');
        }

        $expectedDiscountPercentage = 50;

        $data = $this->cartCustomerData->getSectionData();
        $this->assertEquals($expectedDiscountPercentage, $data['items'][0]['discount_percentage']);
    }
}
