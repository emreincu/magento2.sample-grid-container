<?php
namespace Emakina\Blog\Api\Data;

interface CommentInterface
{
    const COMMENT_ID = 'comment_id'; //Primary Key
    const POST_ID = 'post_id';
    const USER_ID = 'user_id';
    const MESSAGE = 'message';
    const STATUS = 'status';
    const CREATED_DATE = 'created_date';
    const MODIFIED_DATE = 'modified_date';

    #region Getters

    /**
     * Get post id
     * @return int
     */
    public function getPostId();

    /**
     * Get user id
     * @return int
     */
    public function getUserId();

    /**
     * Get name
     *
     * @return string
     */
    public function getMessage();

    /**
     * Get status
     * @return boolean
     */
    public function getStatus();

    /**
     * Get created date
     * @return string
     */
    public function getCreatedDate();

    /**
     * Get modified date
     * @return string
     */
    public function getModifiedDate();
    
    #endregion
    
    #region Setters

    /**
     * Set post id
     * @param $postId
     * @return CommentInterface
     */
    public function setPostId($postId);

    /**
     * Set user id
     * @param $userId
     * @return CommentInterface
     */
    public function setUserId($userId);

    /**
     * Set message
     *
     * @param $message
     * @return CommentInterface
     */
    public function setMessage($message);

    /**
     * Set status
     * @param $status
     * @return CommentInterface
     */
    public function setStatus($status);

    /**
     * Set created date
     * @param $createdDate
     * @return CommentInterface
     */
    public function setCreatedDate($createdDate);

    /**
     * Set modified date
     * @param $modifiedDate
     * @return CommentInterface
     */
    public function setModifiedDate($modifiedDate);

    #endregion
}
