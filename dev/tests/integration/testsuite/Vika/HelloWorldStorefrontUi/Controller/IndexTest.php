<?php
declare(strict_types=1);

namespace Vika\HelloWorldStorefrontUi\Controller;

use Magento\TestFramework\TestCase\AbstractController;

class IndexTest extends AbstractController
{
    public static function loadFixture()
    {
        include __DIR__ . '/../_files/index.php';
    }

    /**
     * @magentoDataFixture Vika/HelloWorldStorefrontUi/_files/index.php
     */
    public function testIndexAction()
    {
        $this->dispatch('helloworld/index/index');
        $responseBody = $this->getResponse()->getBody();

        $this->assertContains('HelloWorld2132342354', $responseBody);
    }
}
