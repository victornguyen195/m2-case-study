<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Config;

use Magento\Framework\Config\ConverterInterface;

/**
 * Converter of block_types.xml content into array format
 */
class Converter implements ConverterInterface
{

    /**
     * @var array
     */
    private static $convertFields = ['title', 'class_name', 'template'];

    /**
     * @param \DOMDocument $source
     *
     * @return array
     */
    public function convert($source): array
    {
        $types = [];
        /** @var \DOMNodeList $config */
        $config = $source->getElementsByTagName('block_types');

        /** @var \DOMElement $configItem */
        foreach ($config as $configItem) {
            foreach ($configItem->childNodes as $configType) {
                if ($configType->nodeType != XML_ELEMENT_NODE) {
                    continue;
                }

                $item = [];
                foreach (self::$convertFields as $field) {
                    if ($node = $configType->getElementsByTagName($field)->item(0)) {
                        $item[$field] = $node->nodeValue;
                    }
                }

                $types[$configType->attributes->getNamedItem('id')->nodeValue] = $item;
            }
        }

        return ['types' => $types];
    }
}
