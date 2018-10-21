<?php
namespace Emakina\Blog\Controller\Adminhtml\Post;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Emakina\Blog\Model\Post as Post;

 
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

        /* We check if we receive the parameter "post" (if the form is sent), 
        if yes then we save the post in the database 
        */
       
        $postDatas = $this->getRequest()->getParam('post');
        $fileDatas = $this->getRequest()->getFiles('post');
        if(is_array($postDatas)) {
            $post = $this->_objectManager->create(Post::class);
            $postUrl = urlEncode($postDatas['post_title']);

            if(isset($fileDatas['post_image'])) {
                try{
                    $postImage = explode(".", $fileDatas['post_image']['name']);
                    
                    $target = $this->_mediaDirectory->getAbsolutePath('customUploads/');        
                    /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => $fileDatas['post_image']]);
                    /** Allowed extension types */
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'zip', 'doc']);
                    /** rename file name if already exists */
                    $uploader->setAllowRenameFiles(true);
                    /** upload file in folder "mycustomfolder" */
                    $postImageName = md5(time() . $postImage[0]).".".$postImage[1];
                    $result = $uploader->save($target, $postImageName);
                    if ($result['file']) {
                        //$this->messageManager->addSuccess(__('File has been successfully uploaded'));
                        $imageName = $postImageName;
                        $postDatas['post_image'] = $imageName;
                    }
                    //return $this->_redirect('emakina_blog/post/postform');
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }

            $postDatas['post_url'] = $postUrl;
            $post->setData($postDatas)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/allposts');
        }

    }
}