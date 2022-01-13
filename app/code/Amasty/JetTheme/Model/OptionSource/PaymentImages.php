<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\OptionSource;

use Amasty\JetTheme\Model\PaymentLink\SvgProvider;
use Magento\Framework\Data\OptionSourceInterface;

class PaymentImages implements OptionSourceInterface
{
    /**
     * @var SvgProvider
     */
    private $svgProvider;

    public function __construct(SvgProvider $svgProvider)
    {
        $this->svgProvider = $svgProvider;
    }

    /**
     * @var array
     */
    private $options = [];

    /**
     * @return array|null
     */
    public function toOptionArray(): array
    {
        if (!$this->options) {
            foreach ($this->svgProvider->getAllSvg() as $key => $svg) {
                $this->options[] = [
                    'value' => $key,
                    'label' => $svg
                ];
            }
        }

        return $this->options;
    }
}
