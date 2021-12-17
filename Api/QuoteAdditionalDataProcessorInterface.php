<?php

namespace MageSuite\QuoteAdditionalData\Api;

interface QuoteAdditionalDataProcessorInterface
{
    public function isEnabled(): bool;

    public function execute(array $sectionData): array;
}
