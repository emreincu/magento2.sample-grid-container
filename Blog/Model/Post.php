<?php
namespace Emakina\Blog\Model;

use Emakina\Blog\Api\Data\PostInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Post extends AbstractModel implements PostInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'emakina_blog_posts';

    /**
     * Blog Is Active True Status
     */
    const BLOG_IS_ACTIVE_TRUE = 1;

    /**
     * Blog Is Active False Status
     */
    const BLOG_IS_ACTIVE_FALSE = 0;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Sliders constructor.
     * @param Context $context
     * @param Registry $registry
     * @param UploaderPool $uploaderPool
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UploaderPool $uploaderPool,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->uploaderPool = $uploaderPool;
    }

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Emakina\Blog\Model\ResourceModel\Post');
    }

    /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(PostInterface::IMAGE);
    }

    /**
     * Set image
     *
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(PostInterface::IMAGE, $image);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(PostInterface::TITLE);
    }

    /**
     * Set title
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(PostInterface::TITLE, $title);
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(PostInterface::CONTENT);
    }

    /**
     * Set content
     *
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        return $this->setData(PostInterface::CONTENT, $content);
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getData(PostInterface::URL);
    }

    /**
     * Set url
     *
     * @param $content
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setData(PostInterface::URL, $url);
    }

    /**
     * Get is_active
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->getData(PostInterface::IS_ACTIVE);
    }

    /**
     * Set is_active
     *
     * @param $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        return $this->setData(PostInterface::IS_ACTIVE, $isActive);
    }

    /**
     * Get view_count
     *
     * @return int
     */
    public function getViewCount()
    {
        return $this->getData(PostInterface::VIEW_COUNT);
    }

    /**
     * Set view_count
     *
     * @param $viewCount
     * @return $this
     */
    public function setViewCount($viewCount)
    {
        return $this->setData(PostInterface::VIEW_COUNT, $viewCount);
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->getData(PostInterface::TAGS);
    }

    /**
     * Set tags
     *
     * @param $tags
     * @return $this
     */
    public function setTags($tags)
    {
        return $this->setData(PostInterface::TAGS, $tags);
    }

    /**
     * Get created_at
     *
     * @return Date
     */
    public function getCreatedAt()
    {
        return $this->getData(PostInterface::CREATED_AT);
    }

    /**
     * Set created_at
     *
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(PostInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get modified_at
     *
     * @return Date
     */
    public function getModifiedAt()
    {
        return $this->getData(PostInterface::MODIFIED_AT);
    }

    /**
     * Set modified_at
     *
     * @param $modifiedAt
     * @return $this
     */
    public function setModifiedAt($modifiedAt)
    {
        return $this->setData(PostInterface::MODIFIED_AT, $modifiedAt);
    }

    /**
     * Get image URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl() . $uploader->getBasePath() . $image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
