<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\Banner\Ui\Component\Banner\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Url;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Escaper;

class Actions extends Column
{
    const VIEW_URL = 'banner/index/view';
    const EDIT_URL = 'banner/index/edit';
    const DELETE_URL = 'banner/index/delete';

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Url $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Url $urlBuilder,
        Escaper $_escaper,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_escaper=$_escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['banner_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->_urlBuilder->getUrl(self::VIEW_URL, ['id' => $item['banner_id']]),
                        'label' => __('View'),
                    ];
                    $item[$name]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(self::EDIT_URL, ['id' => $item['banner_id']]),
                        'label' => __('Edit'),
                    ];
                    $title = $this->_escaper->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->_urlBuilder->getUrl(self::DELETE_URL, ['id' => $item['banner_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
