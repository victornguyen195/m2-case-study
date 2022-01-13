<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\ViewModel\Store;

use Amasty\MegaMenuLite\Model\ConfigProvider;
use Amasty\MegaMenuLite\Model\Detection\MobileDetect;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Menu implements ArgumentInterface
{
    /**
     * @var MobileDetect
     */
    private $mobileDetect;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var Json
     */
    private $json;

    public function __construct(
        MobileDetect $mobileDetect,
        ConfigProvider $configProvider,
        Json $json
    ) {
        $this->mobileDetect = $mobileDetect;
        $this->configProvider = $configProvider;
        $this->json = $json;
    }

    public function serialize(array $data): string
    {
        return $this->json->serialize($data);
    }

    public function isMobile(): bool
    {
        return $this->mobileDetect->isMobile();
    }

    public function getColorSettings(): array
    {
        return $this->configProvider->getColorSettings();
    }

    public function isHamburger(): bool
    {
        return $this->configProvider->isHamburgerEnabled();
    }
}
