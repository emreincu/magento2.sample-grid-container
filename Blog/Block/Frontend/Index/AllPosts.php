<?php

namespace Emakina\Blog\Block\Frontend\Index;

class AllPosts extends \Magento\Framework\View\Element\Template
{
	protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Emakina\Blog\Model\PostFactory $postFactory
	)
	{
		$this->_postFactory =$postFactory;
		parent::__construct($context);
	}

	public function getAllPosts(){
		$post = $this->_postFactory->create();
		return $post->getCollection();
	}
}