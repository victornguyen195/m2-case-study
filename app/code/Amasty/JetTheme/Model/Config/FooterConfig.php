<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\Config;

class FooterConfig
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getConfigByType(string $type): array
    {
        return $this->config[$type] ?? [];
    }
}
