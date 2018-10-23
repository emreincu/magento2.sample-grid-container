<?php

namespace Emakina\Blog\Block\Adminhtml\Post\Edit;
use Magento\Framework\UrlInterface;
use Emakina\Blog\Model\Post\Constant\Constants;
 
class PostImage extends \Magento\Backend\Block\Template
{
    protected $postFactory;
    protected $_template = 'image/post-image.phtml';
 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Emakina\Blog\Model\PostFactory $postFactory,
        array $data = []
    ) {
        $this->postFactory = $postFactory;
        parent::__construct($context, $data);
    }

	public function getImage(){
        $postId = (int)$this->getRequest()->getParam('post_id');
        
        try {
            $collection = $this->postFactory->create();
            $postRecord = $collection->load($postId);
            if($postRecord->getPostId()) {
                $mediapath = $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]);
                $fullPath = $mediapath . Constants::IMG_UPL_PATH . $postRecord->getPostImage();
                
                return $fullPath;
            }else{
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
	}

}