<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\ExpertReview\Ui\Component\Expert\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Escaper;

class Actions extends Column
{
    const EDIT_URL = 'expert/index/edit';
    const DELETE_URL = 'expert/index/delete';

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
        UrlInterface  $urlBuilder,
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
                if (isset($item['expert_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(self::EDIT_URL, ['id' => $item['expert_id']]),
                        'label' => __('Edit'),
                    ];
                    $title = $this->_escaper->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->_urlBuilder->getUrl(self::DELETE_URL, ['id' => $item['expert_id']]),
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
