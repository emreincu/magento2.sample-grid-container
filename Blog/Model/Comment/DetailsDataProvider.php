<?php
namespace Emakina\Blog\Model\Comment;
use Emakina\Blog\Model\ResourceModel\Comment\CollectionFactory;
class DetailsDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $_customerRepositoryInterface;
    
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param CollectionFactory $commentCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        CollectionFactory $commentCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $commentCollectionFactory->create();
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData() {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $comment) {
            $customerId = $comment->getUserId();
            // notre fieldset s'apelle "post" d'ou ce tableau pour que magento puisse retrouver ses datas :
            $customer = $this->_customerRepositoryInterface->getById($customerId);
            $customerData = $customer->__toArray();

            $data = array_merge($customerData, $comment->getData());
            
            //$this->loadedData[$comment->getCommentId()]['comment'] = $data;
            

            $this->loadedData[$comment->getCommentId()]['blog']['comment'] = $comment->getData();
            $this->loadedData[$comment->getCommentId()]['blog']['customer'] = $customerData;

            //$post->getPostId : PostId declared in 'postform.xml'
            
        }
        return $this->loadedData;
    }
}