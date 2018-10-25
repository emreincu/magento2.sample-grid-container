<?php
namespace Emakina\Blog\Controller\Adminhtml;

use Emakina\Blog\Api\PostRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;

abstract class Post extends Action
{
    /**
     * @var string
     */
    const ACTION_RESOURCE = 'Emakina_Blog::post';

    /**
     * Image repository
     *
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Result Page Factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Date filter
     *
     * @var Date
     */
    protected $dateFilter;

    /**
     * Sliders constructor.
     *
     * @param Registry $registry
     * @param PostRepositoryInterface $postRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        PostRepositoryInterface $postRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context
    ) {
        parent::__construct($context);
        $this->coreRegistry = $registry;
        $this->postRepository = $postRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->dateFilter = $dateFilter;
    }
}
