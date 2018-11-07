<?php
namespace Emakina\Blog\Model\ResourceModel;


class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	/**
     * Initialize resource model
     *
     * @return void
     */
	protected function _construct()
	{
		$this->_init('emakina_blog_comments', 'comment_id');
	}
	
}
