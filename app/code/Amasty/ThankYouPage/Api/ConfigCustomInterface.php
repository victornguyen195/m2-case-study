<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Api;

interface ConfigCustomInterface extends ConfigBasicInterface
{

    /**
     * @return string
     */
    public function getBlockTitle(): string;

    /**
     * @return string
     */
    public function getBlockSubTitle(): string;

    /**
     * @return string
     */
    public function getBlockText(): string;

    /**
     * @return bool
     */
    public function isBlockUseCmsBlock(): bool;

    /**
     * @return string
     */
    public function getCmsBlockId(): string;

    /**
     * @return string|null
     */
    public function getBackgroundImage(): ?string;
}
