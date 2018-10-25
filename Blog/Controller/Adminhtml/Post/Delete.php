<?php
namespace Emakina\Blog\Controller\Adminhtml\Post;

use Emakina\Blog\Controller\Adminhtml\Post;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Post
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $postId = $this->getRequest()->getParam('post_id');
        if ($postId) {
            try {
                $this->postRepository->deleteById($postId);
                $this->messageManager->addSuccessMessage(__('The post has been deleted.'));
                $resultRedirect->setPath('emakinablog/post/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The post no longer exists.'));
                return $resultRedirect->setPath('emakinablog/post/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('emakinablog/post/index', ['post_id' => $postId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the post'));
                return $resultRedirect->setPath('emakinablog/post/edit', ['post_id' => $postId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find the post to delete.'));
        $resultRedirect->setPath('emakinablog/post/index');
        return $resultRedirect;
    }
}
