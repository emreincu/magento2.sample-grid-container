<?php
namespace Emakina\Blog\Controller\Adminhtml\Post;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Emakina\Blog\Model\Post as Post;
use Emakina\Blog\Model\Post\Constant\Constants;

 
class PostForm extends \Magento\Backend\App\Action 
{
    protected $_mediaDirectory;
    protected $_fileUploaderFactory;
    
    public function __construct(
        Action\Context $context,        
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
    }

    /**
     * Edit A Contact Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute() 
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
        
        $postData = $this->getRequest()->getParam('post');
        $postImage = $this->getRequest()->getFiles('post')['post_image'];

        if(is_array($postData)) {
            $isFormOkey = true;

            $postData['post_url'] = $this->createUrl($postData['post_title']);
            if($postImage['size'] > 0) {
                try{
                    $postImageNameArray= explode(".", $postImage['name']);
                    $postImageName = md5(time() . $postImageNameArray[0]).".". end($postImageNameArray);
                    
                    $target = $this->_mediaDirectory->getAbsolutePath(Constants::IMG_UPL_PATH); 
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => $postImage]);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'zip', 'doc']);
                    $uploader->setAllowRenameFiles(true);
                    $result = $uploader->save($target, $postImageName);
                    if (!$result['file']) {
                        $this->messageManager->addError(__('The image could not uploaded!'));
                        $isFormOkey = false;
                    }
                    $postData['post_image'] = $postImageName;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $isFormOkey = false;
                }
            }else{
                if(!isset($postData['post_id'])) {
                    $this->messageManager->addError(__('Please select a post image!'));
                    $isFormOkey = false;
                }
            }
            
            $redirectUrl = "allposts";
            if(!$isFormOkey) {
                if(!isset($postData['post_id'])){
                    return $this->_redirect('*/*/postform');
                }else{
                    return $this->_redirect('*/*/postform/post_id/' . $postData['post_id']);
                }
            }

            $post = $this->_objectManager->create(Post::class);
            $post->setData($postData)->save();

            $this->messageManager->addSuccess(__('Post has beeen saved sucessfully'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/allposts');
        }


    }

    private function createUrl($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}