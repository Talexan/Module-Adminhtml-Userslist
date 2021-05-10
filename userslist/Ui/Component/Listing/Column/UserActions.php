<?php

namespace Talexan\UsersList\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class prepare User Actions
 */
class UserActions extends Column
{
    /** Url path */
    const TALEXAN_USER_URL_PATH_EDIT = 'adminhtml/grid/edit';
    const TALEXAN_USER_URL_PATH_DELETE = 'adminhtml/grid/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::TALEXAN_USER_URL_PATH_EDIT, ['id' => $item['id']]),
                        'label' => __('Edit'),
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::TALEXAN_USER_URL_PATH_DELETE, ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete user'),
                            'message' => __('Are you sure you want to delete a %1 record?', $item['id']),
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
