<?php
namespace Emakina\Blog\Api\Data;

interface PostInterface
{
    const POST_ID = 'post_id'; //PK
    const IMAGE = 'image';
    const TITLE = 'title';
    const CONTENT = 'content';
    const URL = 'url';
    const IS_ACTIVE = 'is_active';
    const VIEW_COUNT = 'view_count';
    const TAGS = 'tags';
    const CREATED_DATE = 'created_date';
    const MODIFIED_DATE = 'modified_date';

    #region Getters

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string
     */
    public function getContent();

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get is_active
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Get viewCount
     *
     * @return int
     */
    public function getViewCount();

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags();

    /**
     * Get createdAt
     *
     * @return date
     */
    public function getCreatedDate();

    /**
     * Get modifiedAt
     *
     * @return date
     */
    public function getModifiedDate();

    #endregion

    #region Setters

    /**
     * Set image
     *
     * @param $image
     * @return PostInterface
     */
    public function setImage($image);

    /**
     * Set title
     *
     * @param $title
     * @return PostInterface
     */
    public function setTitle($title);

    /**
     * Set content
     *
     * @param $content
     * @return PostInterface
     */
    public function setContent($content);

    /**
     * Set url
     *
     * @param $url
     * @return PostInterface
     */
    public function setUrl($url);

    /**
     * Set isActive
     *
     * @param $isActive
     * @return PostInterface
     */
    public function setIsActive($isActive);

    /**
     * Set viewCount
     *
     * @param $viewCount
     * @return PostInterface
     */
    public function setViewCount($viewCount);

    /**
     * Set tags
     *
     * @param $tags
     * @return PostInterface
     */
    public function setTags($tags);

    /**
     * Set createdAt
     *
     * @param $createdDate
     * @return PostInterface
     */
    public function setCreatedDate($createdDate);

    /**
     * Set updatedAt
     *
     * @param $updatedDate
     * @return PostInterface
     */
    public function setModifiedDate($updatedDate);

    #endregion
}
