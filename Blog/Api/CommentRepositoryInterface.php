<?php
namespace Emakina\Blog\Api;

use Emakina\Blog\Api\Data\CommentInterface;

/**
 * @api
 */
interface CommentRepositoryInterface
{
    
    /**
     * Save comment.
     *
     * @param CommentInterface $comment
     * @return CommentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CommentInterface $comment);
    
    /**
     * Add a new comment.
     * @api
     * @param int $postId
     * @param string $message
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addComment($postId, $message);

    /**
     * Retrieve All Posts.
     * @api
     * @param int $postId
     * @return \Emakina\Blog\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * 
     */
    public function getById($postId);


    /**
     * Delete comment.
     *
     * @param CommentInterface $comment
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(CommentInterface $comment);

    /**
     * Delete comment by ID.
     *
     * @param int $commentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($commentId);
}
