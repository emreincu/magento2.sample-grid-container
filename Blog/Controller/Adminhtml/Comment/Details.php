<?php
namespace Emakina\Blog\Controller\Adminhtml\Comment;

use Emakina\Blog\Controller\Adminhtml\Comment;

class Details extends Comment
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $commentId = $this->getRequest()->getParam('comment_id');
        
        $resultPage = $this->resultPageFactory->create();
        
        /*
        $resultPage->setActiveMenu('Emakina_Blog::comment')
            ->addBreadcrumb(__('Comments'), __('Comments'))
            ->addBreadcrumb(__('Manage Comments'), __('Manage Comments'));
        
        if (!$commentId) {
            $this->_redirect('emakinablog/post/index');
        }

        $resultPage->addBreadcrumb(__('Comment Details'), __('Comment Details'));
        $resultPage->getConfig()->getTitle()->prepend(__('Comment Details'));
        */
        return $resultPage;
    }
}
