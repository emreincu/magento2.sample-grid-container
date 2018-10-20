<?php 

namespace Emakina\Blog\Block;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    protected $_urlBuilder;

    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->_urlBuilder = $urlBuilder;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    protected function getNodeAsArray()
    {
        return [
            'name' => __('Blog'),
            'id' => 'emakina_blog',
            'url' => $this->_urlBuilder->getUrl(null, ['_direct' =>'blog/index/allposts']),
            'has_active' => false,
            'is_active' => false // (expression to determine if menu item is selected or not)
        ];
    }
}