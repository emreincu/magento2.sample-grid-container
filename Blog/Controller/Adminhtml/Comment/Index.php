<?php
namespace Emakina\Blog\Controller\Adminhtml\Comment;
use Emakina\Blog\Controller\Adminhtml\Comment;

class Index extends Comment
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $postId = (int) $this->getRequest()->getParam('post_id');
        if(!$postId) {
            $this->_redirect('emakinablog/post/index');
        }
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Emakina_Blog::comment');
        $resultPage->getConfig()->getTitle()->prepend(__('Comments'));
        $resultPage->addBreadcrumb(__('Comments'), __('Comments'));
        return $resultPage;
    }
}
