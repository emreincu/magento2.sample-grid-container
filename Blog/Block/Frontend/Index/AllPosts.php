<?php
namespace Emakina\Blog\Block\Frontend\Index;
use \Emakina\Blog\Model\Uploader;
class AllPosts extends \Magento\Framework\View\Element\Template
{
	protected $_storeManager;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Store\Model\StoreManagerInterface $_storeManager
	)
	{
		$this->_storeManager = $_storeManager;
		parent::__construct($context);
	}
	
	public function getPostImageUrl() {
		$baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		$postImageUrl = $baseUrl . Uploader::IMAGE_PATH;
		return $postImageUrl;
	}


}