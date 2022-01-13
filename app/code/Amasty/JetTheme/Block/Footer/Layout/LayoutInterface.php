<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Block\Footer\Layout;

interface LayoutInterface
{
    /**
     * @param array $layoutConfig
     */
    public function setLayoutConfig(array $layoutConfig): LayoutInterface;
}
