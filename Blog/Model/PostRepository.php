<?php
namespace Emakina\Blog\Model;

use Emakina\Blog\Api\Data\PostInterface;
use Emakina\Blog\Api\Data\PostInterfaceFactory;
use Emakina\Blog\Api\PostRepositoryInterface;
use Emakina\Blog\Model\ResourceModel\Post as ResourcePost;
use Emakina\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourcePost
     */
    protected $resource;

    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * @var PostInterfaceFactory
     */
    protected $postInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    public function __construct(
        ResourcePost $resource,
        PostCollectionFactory $postCollectionFactory,
        PostInterfaceFactory $postInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->postInterfaceFactory = $postInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post)
    {
        try {
            /** @var PostInterface|\Magento\Framework\Model\AbstractModel $post */
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the post: %1',
                $exception->getMessage()
            ));
        }
        return $post;
    }

    /**
     * Get Post record
     *
     * @param $postId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($postId)
    {
        if (!isset($this->instances[$postId])) {
            $post = $this->postInterfaceFactory->create();
            $this->resource->load($post, $postId);
            if (!$post->getId()) {
                throw new NoSuchEntityException(__('Requested Post doesn\'t exist'));
            }
            $this->instances[$postId] = $post;
        }
        return $this->instances[$postId];
    }

    /**
     * @param PostInterface $post
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(PostInterface $post)
    {
        /** @var \Emakina\Blog\Api\Data\PostInterface|\Magento\Framework\Model\AbstractModel $Post */
        $id = $post->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($post);
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
     * @param $postId
     * @return bool
     */
    public function deleteById($postId)
    {
        $post = $this->getById($postId);
        return $this->delete($post);
    }
}
