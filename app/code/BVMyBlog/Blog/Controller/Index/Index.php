<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Index
 *
 * Controller Index
 */
class Index extends Action implements HttpGetActionInterface
{
    protected $_pageFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * Function execute
     */
    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
