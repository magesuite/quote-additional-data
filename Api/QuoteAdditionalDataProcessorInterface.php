<?php

namespace MageSuite\QuoteAdditionalData\Api;

interface QuoteAdditionalDataProcessorInterface
{
    public function execute(array $sectionData);
}
