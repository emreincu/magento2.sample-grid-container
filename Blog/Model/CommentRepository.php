<?php
namespace Emakina\Blog\Model;

use Magento\Customer\Model\CustomerFactory;
use \Magento\Customer\Model\SessionFactory;
use Emakina\Blog\Api\Data\CommentInterface;
use Emakina\Blog\Api\Data\CommentInterfaceFactory;
use Emakina\Blog\Api\CommentRepositoryInterface;
use Emakina\Blog\Model\ResourceModel\Comment as ResourceComment;
use Emakina\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceComment
     */
    protected $resource;

    /**
     * @var CommentCollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * @var CommentInterfaceFactory
     */
    protected $commentInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

	/**
	 * Customer Session Factory
	 * @var SessionFactory;
	 */
	protected $sessionFactory;

    public function __construct(
        ResourceComment $resource,
        CommentCollectionFactory $commentCollectionFactory,
        CommentInterfaceFactory $commentInterfaceFactory,
        CustomerFactory $customerFactory,
		SessionFactory $sessionFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->commentInterfaceFactory = $commentInterfaceFactory;
        $this->customerFactory = $customerFactory;
		$this->sessionFactory = $sessionFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }


    /**
     * @param CommentInterface $comment
     * @return CommentInterface
     * @throws CouldNotSaveException
     */
    public function save(CommentInterface $comment)
    {
        try {
            /** @var CommentInterface|\Magento\Framework\Model\AbstractModel $comment */
            $this->resource->save($comment);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the comment: %1',
                $exception->getMessage()
            ));
        }
        return $comment;
    }

    /**
     * Add a new comment.
     * @api
     * @param int $postId
     * @param string $message
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addComment($postId, $message) {
        try{
            $customerSession = $this->sessionFactory->create();
            if($customerSession->getCustomerId() == null)
                return null;
            
            $customerId = $customerSession->getCustomerId();
            
            if($customerId == null) 
                return null;
            
            //$customer = $this->customerFactory->create()->load((int)($this->customerId));
            
            
            $newData = [
                'id_field_name' => 'comment_id',
                'post_id' => $postId,
                'user_id' => $customerId,
                'message' => $message,
                'status' => 1,
                'created_date' => '2018-11-02 21:48:48',
                'modified_date' => '2018-11-02 21:48:48'
            ];
            $comment = $this->commentInterfaceFactory->create();
            $saveData = $comment->setData($newData)->save();
            if($saveData){
                return true;
            }
            return false;
        }catch(\Exception $e) {
            return false;
        }
        
		
            
            
        if(strlen($comment) > 0) return true;
        else return false;
    }

    /**
     * Retrieve Post.
     * @api
     * @param int $commentId
     * @return \Emakina\Blog\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * 
     */
    public function getById($commentId) {

        if (!isset($this->instances[$commentId])) {
            $comment = $this->commentInterfaceFactory->create();
            $this->resource->load($comment, $commentId);
            if (!$comment->getCommentId()) {
                throw new NoSuchEntityException(__('Requested Comment doesn\'t exist'));
            }
            $this->instances[$commentId] = $comment;
        }
        return $this->instances[$commentId];
    }

    /**
     * Retrieve All Comments By Post ID.
     * @api
     * @param int $postId
     * @return \Emakina\Blog\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByPostId($postId) {
        
        
        try{
            $comment = $this->commentInterfaceFactory->create();
            $comment = $comment->getCollection()
                ->addFieldToFilter('post_id',$postId)
                ->addFieldToFilter('status',1);
            $data = $comment->getData();
            
            if(empty($data)) {
                return null;
            }
            foreach($data as $key => $value) {
                $customer_id = $value['user_id'];
                $customer = $this->customerFactory->create()->load((int)($customer_id));
                $data[$key]['user_email'] = ($customer->getEmail() == null) ? "" : $customer->getEmail();
                $data[$key]['user_firstname'] = ($customer->getFirstname() == null) ? "" : $customer->getFirstname();
                $data[$key]['user_middlename'] = ($customer->getMiddlename() == null) ? "" : $customer->getMiddlename();
                $data[$key]['user_lastname'] = ($customer->getLastname() == null) ? "" : $customer->getLastname();

            }
            return $data;
        }catch(\Exception $e) {
            return null;
        }
    }   

    /**
     * @param CommentInterface $comment
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(CommentInterface $comment)
    {
        /** @var \Emakina\Blog\Api\Data\CommentInterface|\Magento\Framework\Model\AbstractModel $comment */
        $id = $comment->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($comment);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove Post %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }


    /**
     * @param $commentId
     * @return bool
     */
    public function deleteById($commentId)
    {
        $comment = $this->getById($commentId);
        return $this->delete($comment);
    }

}
