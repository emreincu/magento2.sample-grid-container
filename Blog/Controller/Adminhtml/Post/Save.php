<?php
namespace Emakina\Blog\Controller\Adminhtml\Post;

use Emakina\Blog\Api\Data\PostInterface;
use Emakina\Blog\Api\Data\PostInterfaceFactory;
use Emakina\Blog\Api\PostRepositoryInterface;
use Emakina\Blog\Controller\Adminhtml\Post;
use Emakina\Blog\Model\Uploader;
use Emakina\Blog\Model\UploaderPool;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Message\Manager;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;

class Save extends Post
{
    /**
     * @var Manager
     */
    protected $messageManager;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var PostInterfaceFactory
     */
    protected $postFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Save constructor.
     *
     * @param Registry $registry
     * @param PostRepositoryInterface $posteRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Manager $messageManager
     * @param PostInterfaceFactory $postFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        PostRepositoryInterface $postRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Manager $messageManager,
        PostInterfaceFactory $postFactory,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool,
        Context $context
    ) {
        parent::__construct($registry, $postRepository, $resultPageFactory, $dateFilter, $context);
        $this->messageManager = $messageManager;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->uploaderPool = $uploaderPool;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = (int) $this->getRequest()->getParam('post_id');
            if ($id) {
                $model = $this->postRepository->getById($id);
            } else {
                unset($data['post_id']);
                $model = $this->postFactory->create();
            }

            try {
                if (!array_key_exists('image', $data)) {
                    $data['image'] = null;
                } else {
                    $image = $this->getUploader('image')->uploadFileAndGetName('image', $data);

                    $data['image'] = empty($image) ?
                    $model->getImage()
                    :
                    $image;
                }
                $this->dataObjectHelper->populateWithArray($model, $data, PostInterface::class);
                $this->postRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved this post.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __('Something went wrong while saving the post:' . $e->getMessage())
                );
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
