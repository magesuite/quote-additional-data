<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$registry = $objectManager->get(\Magento\Framework\Registry::class);

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

$product = $objectManager->create(\Magento\Catalog\Model\Product::class);

$product->load(400);
if ($product->getId()) {
    $product->delete();
}

$product->load(401);
if ($product->getId()) {
    $product->delete();
}

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);
