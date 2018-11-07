<?php
namespace Emakina\Blog\Controller\Adminhtml\Post;

use Emakina\Blog\Controller\Adminhtml\Post;

class Edit extends Post
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('post_id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Emakina_Blog::post')
            ->addBreadcrumb(__('Posts'), __('Posts'))
            ->addBreadcrumb(__('Manage Posts'), __('Manage Posts'));
        
        if (!$postId) {
            $resultPage->addBreadcrumb(__('New Post'), __('New Post'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Post'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Post'), __('Edit Post'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Post'));
        }
        return $resultPage;
    }
}
