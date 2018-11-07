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

            $newUrl = $this->createUrl($data['title']);
            if(strlen($newUrl) == 0) {
                $this->messageManager->addErrorMessage(__('Post Url can not be empty!'));
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $model['post_id'], '_current' => true]);
            }
            $data['url'] = $newUrl;
            

            try {
                if (!array_key_exists('image', $data)) {
                    $data['image'] = null;
                } else {
                    $image = $this->getUploader('image')->uploadFileAndGetName('image', $data);
                    $data['image'] = empty($image) ? $model['image'] : $image;
                }
                $this->dataObjectHelper->populateWithArray($model, $data, PostInterface::class);
                $this->postRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved this post.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model['post_id'], '_current' => true]);
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

    /**
     * Creates Post URL by Post title
     * @param string $string
     * @param string $seperator
     * @return string
     */
    private function createUrl($string, $separator = '-' ) {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and', "'" => '');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }
}
