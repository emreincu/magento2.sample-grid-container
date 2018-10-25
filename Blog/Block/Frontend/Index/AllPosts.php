<?php
namespace Emakina\Blog\Block\Frontend\Index;

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
		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
	}


}