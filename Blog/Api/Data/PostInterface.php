<?php
namespace Emakina\Blog\Api\Data;

/**
 * @api
 */
interface PostInterface
{
    const POST_ID = 'post_id'; //PK
    const IMAGE = 'image';
    const TITLE = 'title';
    const CONTENT = 'content';
    const URL = 'url';
    const IS_ACTIVE = 'is_active';
    const VIEW_COUNT = 'view_count';
    const TAGS = 'post_tags';
    const CREATED_AT = 'created_at';
    const MODIFIED_AT = 'modified_at';

    #region Getters
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getTitle();

    /**
     * Get image
     *
     * @return string
     */
    public function getContent();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getUrl();

    /**
     * Get image
     *
     * @return string
     */
    public function getIsActive();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getViewCount();

    /**
     * Get image
     *
     * @return string
     */
    public function getTags();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getCreatedAt();

    /**
     * Get image
     *
     * @return string
     */
    public function getModifiedAt();

    #endregion

    #region Setters
    /**
     * Set ID
     *
     * @param $id
     * @return PostInterface
     */
    public function setId($id);

    /**
     * Set image
     *
     * @param $image
     * @return PostInterface
     */
    public function setImage($image);

    /**
     * Set ID
     *
     * @param $id
     * @return PostInterface
     */
    public function setTitle($title);

    /**
     * Set image
     *
     * @param $image
     * @return PostInterface
     */
    public function setContent($content);

    /**
     * Set ID
     *
     * @param $id
     * @return PostInterface
     */
    public function setUrl($url);

    /**
     * Set ID
     *
     * @param $id
     * @return PostInterface
     */
    public function setIsActive($isActive);

    /**
     * Set image
     *
     * @param $image
     * @return PostInterface
     */
    public function setViewCount($viewCount);

    /**
     * Set ID
     *
     * @param $id
     * @return PostInterface
     */
    public function setTags($tags);

    /**
     * Set image
     *
     * @param $image
     * @return PostInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set image
     *
     * @param $image
     * @return PostInterface
     */
    public function setModifiedAt($updatedAt);

    #endregion
}
