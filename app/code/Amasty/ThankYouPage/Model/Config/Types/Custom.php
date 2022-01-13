<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config\Types;

use Amasty\ThankYouPage\Api\ConfigCustomInterface;

class Custom extends Basic implements ConfigCustomInterface
{

    /**#@+
     * xpath field parts
     */
    const FIELD_TITLE = 'title';
    const FIELD_SUB_TITLE = 'sub_title';
    const FIELD_TEXT = 'text';
    const FIELD_USE_CMS_BLOCK = 'use_cms_block';
    const FIELD_CMS_BLOCK = 'cms_block';
    const FIELD_BACKGROUND_IMAGE = 'background_image';

    /**#@-*/

    /**
     * @return string
     */
    public function getBlockTitle(): string
    {
        return (string)$this->getValue($this->getGroupPrefix() . self::FIELD_TITLE);
    }

    /**
     * @return string
     */
    public function getBlockSubTitle(): string
    {
        return (string)$this->getValue($this->getGroupPrefix() . self::FIELD_SUB_TITLE);
    }

    /**
     * @return string
     */
    public function getBlockText(): string
    {
        return (string)$this->getValue($this->getGroupPrefix() . self::FIELD_TEXT);
    }

    /**
     * @return bool
     */
    public function isBlockUseCmsBlock(): bool
    {
        return $this->isSetFlag($this->getGroupPrefix() . self::FIELD_USE_CMS_BLOCK);
    }

    /**
     * @return string
     */
    public function getCmsBlockId(): string
    {
        return $this->getValue($this->getGroupPrefix() . self::FIELD_CMS_BLOCK);
    }

    /**
     * @return string|null
     */
    public function getBackgroundImage(): ?string
    {
        return $this->getValue($this->getGroupPrefix() . self::FIELD_BACKGROUND_IMAGE);
    }
}
