<?php
namespace Emakina\Blog\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'comment_id';
	protected $_eventPrefix = 'emakina_blog_comment_collection';
	protected $_eventObject = 'comment_collection';
	protected function _construct()
	{
		$this->_init('Emakina\Blog\Model\Comment', 'Emakina\Blog\Model\ResourceModel\Comment');
	}

}