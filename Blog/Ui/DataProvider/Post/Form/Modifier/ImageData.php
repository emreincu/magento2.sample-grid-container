<?php
namespace Emakina\Blog\Ui\DataProvider\Post\Form\Modifier;

use Emakina\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Emakina\Blog\Model\Uploader;
use Magento\Store\Model\StoreManagerInterface;

class ImageData implements ModifierInterface
{
    /**
     * @var \Emakina\Blog\Model\ResourceModel\Post\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface;
     */
    protected $storeManager;

    /**
     * @param CollectionFactory $postCollectionFactory
     */
    public function __construct(
        CollectionFactory $postCollectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->storeManager = $storeManager;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    /**
     * @param array $data
     * @return array|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function modifyData(array $data)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $items = $this->collection->getItems();


        /** @var $image \Emakina\Blog\Model\Image */
        foreach ($items as $image) {

            $_data = $image->getData();
            if (isset($_data['image'])) {
                $imageArr = [];
                $imageArr[0]['name'] = 'image';
                $imageArr[0]['url'] = $mediaUrl . Uploader::IMAGE_PATH . $image->getImage();
                $_data['image'] = $imageArr;
            }
            $image->setData($_data);
            $data[$image->getId()] = $_data;
        }
        return $data;
    }
}
