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
        
        $FileDatas = $this->getRequest()->getFiles('post');
        
        if(is_array($FileDatas) && isset($FileDatas['post_image']['name'])) {
            try{
                $new_name_array = explode(".", $FileDatas['post_image']['name']);
                
                
                $target = $this->_mediaDirectory->getAbsolutePath('customUploads/');        
                /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
                $uploader = $this->_fileUploaderFactory->create(['fileId' => $FileDatas['post_image']]);
                /** Allowed extension types */
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'zip', 'doc']);
                /** rename file name if already exists */
                $uploader->setAllowRenameFiles(true);
                /** upload file in folder "mycustomfolder" */
                $new_name = md5(time() . $new_name_array[0]).".".$new_name_array[1];
                $result = $uploader->save($target, $new_name);
                if ($result['file']) {
                    $this->messageManager->addSuccess(__('File has been successfully uploaded')); 
                }
                return $this->_redirect('emakina_blog/post/postform');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
    }
}