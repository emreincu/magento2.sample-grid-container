<?php

namespace Emakina\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action\Context;
use Emakina\Blog\Model\PostFactory;
use Magento\Framework\Controller\ResultFactory;

class PostDelete extends \Magento\Backend\App\Action {
    protected $postFactory;

    public function __construct(Context $context, PostFactory $postFactory)
    {
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    public function execute() {
        $postId = (int)$this->getRequest()->getParam('post_id');
        try {
            $collection = $this->postFactory->create();
            $postRecord = $collection->load($postId);
            if($postRecord->getPostId()) {
                $postRecord->delete();
                $this->messageManager->addSuccess(__('Post has beeen deleted sucessfully'));
            }else{
                $this->messageManager->addError(__('Post is not found!'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/allposts');
    }
}


