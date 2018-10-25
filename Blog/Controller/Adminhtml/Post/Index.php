<?php
namespace Emakina\Blog\Controller\Adminhtml\Post;

use Emakina\Blog\Controller\Adminhtml\Post;

class Index extends Post
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Emakina_Blog::post');
        $resultPage->getConfig()->getTitle()->prepend(__('Post'));
        $resultPage->addBreadcrumb(__('Post'), __('Post'));
        return $resultPage;
    }
}
