<?php
namespace Emakina\Blog\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'emakina_blog_post';

	protected $_cacheTag = 'emakina_blog_post';

	protected $_eventPrefix = 'emakina_blog_post';

	protected function _construct()
	{
		$this->_init('Emakina\Blog\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}