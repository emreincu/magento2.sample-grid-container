<?php
namespace Emakina\Blog\Model;
use Emakina\Blog\Api\Post;

 
class PostApi implements Post
{
    private $collection; 

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Emakina\Blog\Model\PostFactory $postFactory
        )
    {
        $post = $postFactory->create();
        $this->collection = $post->getCollection();

    }
    public function getById($postId) 
    {
        $postRecord = $this->collection->addFieldToFilter('post_id', $postId);
        return $postRecord->getData();
    }

    public function getAll() {
        $posts = $this->collection;
        return $posts->getData();
    }
}