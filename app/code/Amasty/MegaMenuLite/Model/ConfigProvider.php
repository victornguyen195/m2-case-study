<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Model;

use Amasty\Base\Model\ConfigProviderAbstract;
use Amasty\MegaMenuLite\Model\OptionSource\ColorTemplate;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider extends ConfigProviderAbstract
{
    const ENABLED = 'general/enabled';

    const HAMBURGER_ENABLED = 'general/hamburger_enabled';

    const SUBMENU_BACKGROUND_IMAGE = 'color/submenu_background_image';

    const MENU_BACKGROUND_COLOR = 'color/menu_background';

    const COLOR_TEMPLATE = 'color/color_template';

    const COLOR = 'color';

    const DESIGN_HEADER_WELCOME = 'design/header/welcome';

    const DESIGN_HEADER_LOGO_SRC = 'design/header/logo_src';

    /**
     * @var string
     */
    protected $pathPrefix = 'ammegamenu/';

    public function isEnabled(?int $storeId = null): ?bool
    {
        return (bool)$this->isSetFlag(self::ENABLED, $storeId);
    }

    public function isHamburgerEnabled(?int $storeId = null): ?bool
    {
        return (bool)$this->isSetFlag(self::HAMBURGER_ENABLED, $storeId);
    }

    public function getColorTemplate(): ?string
    {
        return (string)$this->getValue(self::COLOR_TEMPLATE);
    }

    public function isSomeTemplateApplied(): bool
    {
        return $this->getColorTemplate() !== ColorTemplate::BLANK;
    }

    public function getColorSettings(): array
    {
        return $this->getValue(self::COLOR);
    }

    public function getWelcomeMessage(): ?string
    {
        return $this->scopeConfig->getValue(self::DESIGN_HEADER_WELCOME, ScopeInterface::SCOPE_STORE);
    }

    public function getHeaderLogoSrc(): ?string
    {
        return $this->scopeConfig->getValue(self::DESIGN_HEADER_LOGO_SRC, ScopeInterface::SCOPE_STORE);
    }

    public function getSubmenuBackgroundImage(): ?string
    {
        return $this->getValue(self::SUBMENU_BACKGROUND_IMAGE);
    }
}
