<?php
namespace Emakina\Blog\Controller\Index;

class Post extends \Magento\Framework\App\Action\Action {

    protected $_pageFactory;

    public function __construct(
    	\Magento\Framework\App\Action\Context $context, //magento/framework/App/Action/Context.php
    	\Magento\Framework\View\Result\PageFactory $pageFactory //framework/View/Result/PageFactory.php
    ) {
    	$this->_pageFactory = $pageFactory;
    	return parent::__construct($context);
    }

    public function execute() {
		return $this->_pageFactory->create();
  }
  
}