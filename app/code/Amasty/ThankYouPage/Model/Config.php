<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model;

use Amasty\Base\Model\ConfigProviderAbstract;
use Amasty\ThankYouPage\Block\Onepage\Success\Types\Crosssell;
use Magento\Newsletter\Model\Subscriber;
use Magento\Store\Model\ScopeInterface;

class Config extends ConfigProviderAbstract
{
    /**
     * xpath prefix of module (section)
     */
    protected $pathPrefix = 'amasty_thank_you_page/';

    /**#@+
     * xpath group parts
     */
    const GENERAL_BLOCK = 'general/';
    const COUPON_BLOCK = 'coupon/';
    const ADVANCED_BLOCK = 'advanced_layout_management/';
    const PREVIEW_BLOCK = 'preview_settings/';

    /**#@-*/

    /**#@+
     * xpath field parts
     */
    const FIELD_BLOCKS_SORTING = 'blocks_sorting';
    const FIELD_BLOCKS_RULE_ID = 'rule_id';
    const FIELD_BLOCKS_DISPLAY = 'display';
    const FIELD_BLOCKS_MARKUP_EDITOR = 'markup_editor';
    const FIELD_BLOCKS_INCREMENT_ID = 'increment_id';
    const FIELD_MOBILE_VIEW = 'mobile_view';

    /**#@-*/

    /**
     * Comma separated sorted block ids
     *
     * @return string
     */
    public function getBlockSorting(): string
    {
        return $this->getValue(self::GENERAL_BLOCK . self::FIELD_BLOCKS_SORTING);
    }

    /**
     * @return int
     */
    public function getCouponRuleId(): int
    {
        return (int)$this->getValue(self::COUPON_BLOCK . self::FIELD_BLOCKS_RULE_ID);
    }

    /**
     * @param null $storeId
     * @param string $scope
     *
     * @return bool
     */
    public function isMarkupEnabled($storeId = null, $scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->isSetFlag(self::ADVANCED_BLOCK . self::FIELD_BLOCKS_DISPLAY, $storeId, $scope);
    }

    /**
     * @return string
     */
    public function getMarkupEditor(): string
    {
        return $this->getValue(self::ADVANCED_BLOCK . self::FIELD_BLOCKS_MARKUP_EDITOR);
    }

    /**
     * @param string $block
     *
     * @return bool
     */
    public function isBlockEnabled(string $block): bool
    {
        if ($block === 'cross_sell') {
            $block = Crosssell::BLOCK_CONFIG_NAME;
        }

        return $this->isSetFlag('block_' . $block . '/' . self::FIELD_BLOCKS_DISPLAY);
    }

    /**
     * @return string|null
     */
    public function getOrderIncrementId(): ?string
    {
        return $this->getValue(self::PREVIEW_BLOCK . self::FIELD_BLOCKS_INCREMENT_ID);
    }

    /**
     * @return bool
     */
    public function getAllowGuestSubscribe(): bool
    {
        return $this->scopeConfig->isSetFlag(Subscriber::XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG);
    }

    /**
     * @return bool
     */
    public function isForceOneColumnMobileViewEnabled(): bool
    {
        return $this->isSetFlag(self::ADVANCED_BLOCK . self::FIELD_MOBILE_VIEW);
    }
}
