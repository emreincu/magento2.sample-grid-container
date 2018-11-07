<?php
namespace Emakina\Blog\Controller\Adminhtml\Comment;

use Emakina\Blog\Controller\Adminhtml\Comment;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Comment
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $commentId = $this->getRequest()->getParam('comment_id');
        if ($commentId) {
            try {
                $this->commentRepository->deleteById($commentId);
                $this->messageManager->addSuccessMessage(__('The comment has been deleted.'));
                $resultRedirect->setPath('emakinablog/post/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The comment no longer exists.'));
                return $resultRedirect->setPath('emakinablog/post/index');
            } catch (LocalizedException $e) { 
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('emakinablog/post/index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the comment'));
                return $resultRedirect->setPath('emakinablog/post/index');
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find the comment to delete.'));
        $resultRedirect->setPath('emakinablog/post/index');
        return $resultRedirect;
    }
}