<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\Config\Source\Fonts;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Module\Manager;

class FontType implements OptionSourceInterface
{
    const DEFAULT = 'default';
    const GOOGLE = 'google';
    const NON_LATIN = 'non-latin';

    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [
            ['value' => self::DEFAULT, 'label' => __('Default')],
            ['value' => self::GOOGLE, 'label' => __('Google')],
        ];

        if ($this->moduleManager->isEnabled('Amasty_JetNonLatinFonts')) {
            $options[] = ['value' => self::NON_LATIN, 'label' => __('Non-Latin')];
        }

        return $options;
    }
}
