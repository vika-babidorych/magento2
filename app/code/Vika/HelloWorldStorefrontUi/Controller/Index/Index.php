<?php
declare(strict_types=1);

namespace Vika\HelloWorldStorefrontUi\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Renders index page
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory $pageFactory
     */
    private $pageFactory;

    /**
     * @inheritdoc
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
