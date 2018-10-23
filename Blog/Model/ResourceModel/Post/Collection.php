<?php
namespace Emakina\Blog\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'post_id';
	protected $_eventPrefix = 'emakina_blog_post_collection';
	protected $_eventObject = 'post_collection';
	protected function _construct()
	{
		$this->_init('Emakina\Blog\Model\Post', 'Emakina\Blog\Model\ResourceModel\Post');
	}

}