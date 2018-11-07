<?php
namespace Emakina\Blog\Block\Frontend\Index;


use \Emakina\Blog\Api\CommentRepositoryInterface;
use \Emakina\Blog\Model\Uploader;
use \Magento\Customer\Model\CustomerFactory;
use \Magento\Customer\Model\SessionFactory;

class Post extends \Magento\Framework\View\Element\Template
{
    /**
     * Comment repository
     *
     * @var CommentRepositoryInterface
     */
	protected $commentRepository;

	/**
	 * Costumer factory
	 * @var CostumerFactory
	 */
	protected $customerFactory;

	/**
	 * Customer Session Factory
	 * @var SessionFactory;
	 */
	protected $sessionFactory;

	/**
	 * Customer Session
	 * @var CustomerSession
	 */
	protected $customerSession;

	/**
	 * Logedin customer id
	 * @var int
	 */
	protected $customerId = null;


	protected $_urlBuilder;
	protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		CommentRepositoryInterface $commentRepository,
		CustomerFactory $customerFactory,
		SessionFactory $sessionFactory,
		\Emakina\Blog\Model\PostFactory $_postFactory,
		\Magento\Framework\UrlInterface $_urlBuilder
	)
	{
		$this->_urlBuilder = $_urlBuilder;
		$this->commentRepository = $commentRepository;
		$this->customerFactory = $customerFactory;
		$this->sessionFactory = $sessionFactory;
		$this->customerSession = $this->sessionFactory->create();
		if($this->customerSession->getCustomerId() != null) {
			$this->customerId = $this->customerSession->getCustomerId();
		}
 		
		$this->_postFactory = $_postFactory;
		parent::__construct($context);
	}
	public function getPostUrl() {
		$url = $this->getRequest()->getParam('url');
		
		return $url;
	}
	public function getPostImageBasePath() {
		$baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		$postImageBasePath = $baseUrl . Uploader::IMAGE_PATH;
		return $postImageBasePath;
	}

	public function getPostComments($postId) {
		$model = $this->commentRepository->getById($postId);
		return $model;
	}
	
	public function getCurrentCosturmerData() {
		if($this->customerId != null) {
			$customer = $this->customerFactory->create()->load((int)($this->customerId));
			return $customer;
		}
		return null;
		
	}


}
