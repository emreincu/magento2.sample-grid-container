<?php
namespace Emakina\Blog\Model;

use Emakina\Blog\Api\Data\CommentInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
 

class Comment extends AbstractModel implements CommentInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'emakina_blog_comments';

    /**
     * Sliders constructor.
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        
    }

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Emakina\Blog\Model\ResourceModel\Comment');
    }

    /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG .'_'. $this->getCommentId()];
    }

#region Getters

    /**
     * Get post id
     * @return int
     */
    public function getPostId(){
        return $this->getData(CommentInterface::POST_ID);
    }

    /**
     * Get user id
     * @return int
     */
    public function getUserId(){
        return $this->getData(CommentInterface::USER_ID);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData(CommentInterface::MESSAGE);
    }

    /**
     * Get status
     * @return boolean
     */
    public function getStatus(){
        return $this->getData(CommentInterface::STATUS);
    }

    /**
     * Get created date
     * @return string
     */
    public function getCreatedDate(){
        return $this->getData(CommentInterface::CREATED_DATE);
    }

    /**
     * Get modified date
     * @return string
     */
    public function getModifiedDate(){
        return $this->getData(CommentInterface::MODIFIED_DATE);
    }
    
    #endregion
    
    #region Setters

    /**
     * Set post id
     * @param $postId
     * @return CommentInterface
     */
    public function setPostId($postId){
        return $this->setData(CommentInterface::POST_ID, $postId);
    }

    /**
     * Set user id
     * @param $userId
     * @return CommentInterface
     */
    public function setUserId($userId){
        return $this->setData(CommentInterface::USER_ID, $userId);
    }

    /**
     * Set name
     *
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        return $this->setData(CommentInterface::MESSAGE, $message);
    }

    /**
     * Set status
     * @param $status
     * @return CommentInterface
     */
    public function setStatus($status){
        return $this->setData(CommentInterface::STATUS, $status);
    }

    /**
     * Set created date
     * @param $createdDate
     * @return CommentInterface
     */
    public function setCreatedDate($createdDate){
        return $this->setData(CommentInterface::CREATED_DATE, $createdDate);
    }

    /**
     * Set modified date
     * @param $modifiedDate
     * @return CommentInterface
     */
    public function setModifiedDate($modifiedDate){
        return $this->setData(CommentInterface::MODIFIED_DATE, $modifiedDate);
    }

    #endregion
    


}
