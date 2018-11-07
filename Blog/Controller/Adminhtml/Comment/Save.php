<?php

namespace Emakina\Blog\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use Emakina\Blog\Api\Data\CommentInterface;
use Emakina\Blog\Api\Data\CommentInterfaceFactory;
use Emakina\Blog\Api\CommentRepositoryInterface;
use Emakina\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Message\Manager;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;

class Save extends Comment
{

    /**
     * @var Manager
     */
    protected $messageManager;

    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * @var CommentInterfaceFactory
     */
    protected $commentFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;


    /**
     * Save constructor.
     *
     * @param Registry $registry
     * @param CommentRepositoryInterface $commenteRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Manager $messageManager
     * @param CommentInterfaceFactory $commentFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param Context $context
     */

    public function __construct(
        Registry $registry,
        CommentRepositoryInterface $commentRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Manager $messageManager,
        CommentInterfaceFactory $commentFactory,
        DataObjectHelper $dataObjectHelper,
        Context $context
    ) {
        parent::__construct($registry, $commentRepository, $resultPageFactory, $dateFilter, $context);
        $this->messageManager = $messageManager;
        $this->commentFactory = $commentFactory;
        $this->commentRepository = $commentRepository;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $data = $this->getRequest()->getPostValue()['blog'];
        
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $commentData = $data['comment'];
            $customerData = $data['customer'];
            try{
                $newData = [
                    'id_field_name' => 'comment_id',
                    'comment_id' => $commentData['comment_id'],
                    'post_id' => $commentData['post_id'],
                    'user_id' => $customerData['id'],
                    'message' => $commentData['message'],
                    'status' => $commentData['status'],
                    'created_date' => $commentData['created_date'],
                    'modified_date' => $commentData['modified_date']
                ];

                $comment = $this->commentFactory->create();
                $saveData = $comment->setData($newData)->save();

                $this->messageManager->addSuccessMessage(__('You saved this comment.'));
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('emakinablog/comment/index/', ['post_id' => $commentData['post_id']]);
            
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __('Something went wrong while saving the post')
                );
                return $resultRedirect->setPath('emakinablog/post/index/');
            }
        }
    }
}