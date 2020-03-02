<?php
declare(strict_types=1);

namespace Vika\HelloWorldStorefrontUi\Block;

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @var \Vika\HelloWorldStorefrontUi\Block\Index
     */
    protected $block;

    protected function setUp()
    {
        parent::setUp();
        $this->block = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            \Magento\Framework\View\LayoutInterface::class
        )->createBlock(
            \Vika\HelloWorldStorefrontUi\Block\Index::class
        );
    }

    /**
     * @magentoAppArea frontend
     * @magentoDataFixture Vika/HelloWorldStorefrontUi/_files/index.php
     */
    public function testGetHello()
    {
        $this->assertEquals("<h1>HelloWorld2132342354</h1> after suffix.", $this->block->getHello());
    }
}
