<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Plugin\CustomTabs\Block\Product\View;

use Amasty\CustomTabs\Block\Product\View\ProductTab;
use Amasty\JetTheme\ViewModel\ProductCaret\ProductCaretConfigurationViewModel;
use Magento\Framework\View\Element\BlockInterface;

class AddViewModel
{
    /**
     * @var string[]
     */
    private $blockTypesToAdd = [
        'related',
        'upsell',
        'crosssell'
    ];

    /**
     * @var ProductCaretConfigurationViewModel
     */
    private $caretConfigurationViewModel;

    /**
     * @param ProductCaretConfigurationViewModel $caretConfigurationViewModel
     */
    public function __construct(ProductCaretConfigurationViewModel $caretConfigurationViewModel)
    {
        $this->caretConfigurationViewModel = $caretConfigurationViewModel;
    }

    /**
     * @param ProductTab $subject
     * @param BlockInterface|null $result
     * @param string $type
     * @return BlockInterface|null
     */
    public function afterGetProductBlock(ProductTab $subject, ?BlockInterface $result, string $type): ?BlockInterface
    {
        if ($result && in_array($type, $this->blockTypesToAdd)) {
            $result->setAmProductCaretViewModel($this->caretConfigurationViewModel);
        }

        return $result;
    }
}
