<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config\Types;

use Amasty\Base\Model\ConfigProviderAbstract;
use Amasty\ThankYouPage\Api\ConfigBasicInterface;

class Basic extends ConfigProviderAbstract implements ConfigBasicInterface
{

    /**
     * xpath prefix of module (section)
     */
    protected $pathPrefix = 'amasty_thank_you_page/';

    /**
     * @var string
     */
    private $groupPrefix;

    /**#@+
     * xpath field parts
     */
    const FIELD_ENABLED = 'display';
    const FIELD_TITLE = 'title';
    const FIELD_SUB_TITLE = 'sub_title';
    const FIELD_TEXT = 'text';
    const FIELD_USE_CMS_BLOCK = 'use_cms_block';
    const FIELD_CMS_BLOCK = 'cms_block';

    /**#@-*/

    /**
     * @return bool
     */
    public function isBlockEnabled(): bool
    {
        return $this->isSetFlag($this->getGroupPrefix() . self::FIELD_ENABLED);
    }

    /**
     * @return string
     */
    protected function getGroupPrefix(): string
    {
        return $this->groupPrefix . '/';
    }

    /**
     * @param string $groupPrefix
     *
     * @return $this
     */
    public function setGroupPrefix(string $groupPrefix): ConfigBasicInterface
    {
        $this->groupPrefix = $groupPrefix;

        return $this;
    }
}
