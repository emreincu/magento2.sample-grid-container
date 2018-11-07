<?php
namespace Emakina\Blog\Api;

use Emakina\Blog\Api\Data\PostInterface;

/**
 * @api
 */
interface PostRepositoryInterface
{
    /**
     * Save post.
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(PostInterface $post);

    /**
     * Retrieve Post.
     * @api
     * @param int $postId
     * @return \Emakina\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * 
     */
    public function getById($postId);


    /**
     * Retrieve Post.
     * @api
     * @param string $postUrl
     * @return \Emakina\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * 
     */
    public function getByUrl($postUrl);
    
    /**
     * Retrieve All Posts.
     * @api
     * @return \Emakina\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * 
     */
    public function getAll();

    /**
     * Delete image.
     *
     * @param PostInterface $image
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(PostInterface $post);

    /**
     * Delete post by ID.
     *
     * @param int $postId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($postId);
}
