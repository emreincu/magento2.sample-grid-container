<?php
namespace Emakina\Blog\Controller\Adminhtml\Comment;
use Emakina\Blog\Api\CommentRepositoryInterface;
use Emakina\Blog\Controller\Adminhtml\Comment;
use Emakina\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Comment
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var string
     */
    protected $successMessage;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * MassAction constructor.
     *
     * @param Registry $registry
     * @param CommentRepositoryInterface $commentRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param $successMessage
     * @param $errorMessage
     */
    public function __construct(
        Registry $registry,
        CommentRepositoryInterface $commentRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        parent::__construct($registry, $commentRepository, $resultPageFactory, $dateFilter, $context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->successMessage = $successMessage;
        $this->errorMessage = $errorMessage;
    }

    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $comment) {
                $comment->delete();
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __($this->errorMessage));
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('emakinablog/post');
        return $redirectResult;
    }
}