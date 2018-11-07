<?php
namespace Emakina\Blog\Ui\Component\Listing\Column;

use Emakina\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class PostComment extends Column
{
    const URL_PATH_ALL = 'emakinablog/comment/index';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Comment Collection
     * 
     * @var \Emakina\Blog\Model\ResourceModel\Comment\CollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * @param ContextInterface $context
     * @param CollectionFactory $commentCollectionFactory
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        CollectionFactory $commentCollectionFactory,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->commentCollectionFactory = $commentCollectionFactory;
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
                $collectionFactory = $this->commentCollectionFactory->create();
                $commentData = $collectionFactory->addFieldToFilter('post_id', $item['post_id']);
                $commentCount = $commentData->getSize();
                
                if (isset($item['post_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_ALL,
                                [
                                    'post_id' => $item['post_id'],
                                ]
                            ),
                            'label' => __('Comments (' . $commentCount .')'),
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
