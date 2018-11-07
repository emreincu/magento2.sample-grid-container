<?php
namespace Emakina\Blog\Controller\Adminhtml;

use Emakina\Blog\Api\CommentRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;

abstract class Comment extends Action
{
    /**
     * @var string
     */
    const ACTION_RESOURCE = 'Emakina_Blog::comment';

    /**
     * Image repository
     *
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

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
     * @param CommentRepositoryInterface $commentRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        CommentRepositoryInterface $commentRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context
    ) {
        parent::__construct($context);
        $this->coreRegistry = $registry;
        $this->commentRepository = $commentRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->dateFilter = $dateFilter;
    }
}
