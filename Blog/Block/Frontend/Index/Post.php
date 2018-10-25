<?php

namespace Emakina\Blog\Block\Frontend\Index;

class Post extends \Magento\Framework\View\Element\Template
{
	protected $_urlBuilder;
	protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Emakina\Blog\Model\PostFactory $_postFactory,
		\Magento\Framework\UrlInterface $_urlBuilder
	)
	{
		$this->_urlBuilder = $_urlBuilder;
		$this->_postFactory = $_postFactory;
		parent::__construct($context);
	}

	public function getPostId(){
		$postUrl = $this->getRequest()->getParam('post_url');
		$collection = $this->_postFactory->create();
		$post =  $collection->getCollection()->addFieldToFilter('post_url',$postUrl);
		return $post->getFirstItem()->getPostId();
	}

	public function getPostImageUrl() {
		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
	}

}

