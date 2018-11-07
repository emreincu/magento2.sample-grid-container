<?php
namespace Emakina\Blog\Block\Adminhtml\Comment\Details\Buttons;

use Emakina\Blog\Api\CommentRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * @param Context $context
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        Context $context,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->context = $context;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Return Post ID
     *
     * @return int|null
     */
    public function getCommentId()
    {
        $a = $this->commentRepository->getById(
            $this->context->getRequest()->getParam('comment_id')
        );
        if($a != null) {
            return $a[0]['post_id'];
        }
        return null;
        
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
