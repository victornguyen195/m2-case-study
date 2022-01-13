<?php

declare(strict_types=1);

namespace Amasty\JetNonLatinFonts\Model\Config\Source;

use Amasty\JetNonLatinFonts\Model\Font\FileReader;
use Magento\Framework\Data\OptionSourceInterface;

class NonLatinFonts implements OptionSourceInterface
{
    /**
     * @var FileReader
     */
    private $fileReader;

    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $presets = [];
        foreach ($this->fileReader->getFileNames() as $fileName) {
            $fileNameParts = array_map('ucfirst', explode('_', $fileName));
            $presets[] = ['value' => $fileName, 'label' => implode(' ', $fileNameParts)];
        }

        return $presets;
    }
}
