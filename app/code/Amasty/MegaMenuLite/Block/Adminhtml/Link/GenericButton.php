<?php

namespace Amasty\MegaMenuLite\Block\Adminhtml\Link;

use Amasty\MegaMenuLite\Api\Data\Menu\LinkInterface;

class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Registry $registry
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->registry = $registry;
    }

    public function getUrlBuilder()
    {
        return $this->urlBuilder;
    }

    /**
     * @return null|int
     */
    public function getLinkId()
    {
        $link = $this->registry->registry(LinkInterface::PERSIST_NAME);

        return $link ? $link->getEntityId() : null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
