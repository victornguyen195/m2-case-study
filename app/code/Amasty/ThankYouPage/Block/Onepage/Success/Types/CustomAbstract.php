<?php

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Onepage\Success\Types;

use Amasty\ThankYouPage\Api\ConfigCustomInterface;
use Magento\Cms\Block\Block;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Amasty\ThankYouPage\Model\Template\Filter;
use Amasty\ThankYouPage\Model\Config\Blocks;

abstract class CustomAbstract extends Template implements TypesInterface
{
    /**
     * @var ConfigCustomInterface
     */
    protected $config;

    /**
     * @var Block
     */
    protected $cmsBlock;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var Blocks
     */
    protected $blockConfig;

    public function __construct(
        Context $context,
        ConfigCustomInterface $config,
        Block $cmsBlock,
        Filter $filter,
        Blocks $blockConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        // clone config model, so it can be reused with different configuration
        $this->config = clone $config;
        $this->cmsBlock = $cmsBlock;
        $this->config->setGroupPrefix($this->getGroupPrefix());
        $this->filter = $filter;
        $this->blockConfig = $blockConfig;
    }

    /**
     * @return string
     */
    abstract protected function getGroupPrefix(): string;

    /**
     * @return null
     */
    public function getCacheLifetime()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isBlockEnabled();
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->filter->filter($this->config->getBlockTitle());
    }

    /**
     * @return string|null
     */
    public function getSubTitle(): ?string
    {
        return $this->filter->filter($this->config->getBlockSubTitle());
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->filter->filter($this->config->getBlockText());
    }

    /**
     * @return bool
     */
    public function useCmsBlock(): bool
    {
        return $this->config->isBlockUseCmsBlock();
    }

    /**
     * @return string
     */
    public function getCmsBlockContentHtml(): string
    {
        if (!($cmsBlockId = $this->config->getCmsBlockId())) {
            return '';
        }

        return $this->filter->filter($this->cmsBlock->setBlockId($cmsBlockId)->toHtml());
    }

    /**
     * @return string|null
     */
    public function getBackgroundImage(): ?string
    {
        if ($image = $this->config->getBackgroundImage()) {
            return $this->_storeManager->getStore()
                    ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'thankyoupage/' . ltrim($image, '/');
        }

        return null;
    }

    /**
     * @return int
     */
    abstract protected function getWidth(): int;

    /**
     * @return string
     */
    /*public function isMarkupEnabled()
    {
        return $this->blockConfig->isMarkupEnabled(); TODO!!!!!
    }*/
}
