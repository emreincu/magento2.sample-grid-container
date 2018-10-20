<?php
namespace Emakina\Blog\Model\Post;

use Emakina\Blog\Model\ResourceModel\Post\CollectionFactory;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        
        foreach ($items as $post) {
            
            // notre fieldset s'apelle "post" d'ou ce tableau pour que magento puisse retrouver ses datas :
            $this->loadedData[$post->getPostId()]['post'] = $post->getData();
            //$post->getPostId : PostId declared in 'postform.xml'
            
        }


        return $this->loadedData;

    }
}