<?php
declare(strict_types=1);

namespace Vika\HelloWorldAPI\Api;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Vika\HelloWorld\Model\HelloWorldRepository;
use Vika\HelloWorldAPI\Api\Data\HelloWorldAPIInterface;
use Vika\HelloWorldAPI\Api\Data\HelloWorldAPIInterfaceFactory;

/**
 * Tests for hello service.
 */
class HelloWorldAPIRepositoryTest extends WebapiAbstract
{
    const SERVICE_NAME = 'HelloWorldAPIRepositoryV1';
    const SERVICE_VERSION = 'V1';
    const RESOURCE_PATH = '/V1/helloworldapi';

    /**
     * @var HelloWorldAPIInterfaceFactory
     */
    protected $helloWorldAPIInterfaceFactory;

    /**
     * @var HelloWorldAPIRepositoryInterface
     */
    protected $helloWorldRepository;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var HelloWorldAPIInterface|null
     */
    protected $currentHelloWorld;

    /**
     * Execute per test initialization.
     */
    public function setUp()
    {
        $this->helloWorldAPIInterfaceFactory = Bootstrap::getObjectManager()
            ->create(HelloWorldAPIInterfaceFactory::class);
        $this->helloWorldRepository = Bootstrap::getObjectManager()
            ->create(HelloWorldAPIRepositoryInterface::class);
        $this->dataObjectHelper = Bootstrap::getObjectManager()
            ->create(DataObjectHelper::class);
        $this->dataObjectProcessor = Bootstrap::getObjectManager()
            ->create(DataObjectProcessor::class);
    }

    /**
     * Test get HelloWorldAPIInterface
     */
    public function testGet()
    {
        $content = 'Hello content';

        /** @var  HelloWorldAPIInterface $helloDataObject */
        $helloDataObject = $this->helloWorldAPIInterfaceFactory->create();
        $helloDataObject->setContent($content);
        $this->currentHelloWorld = $this->helloWorldRepository->save($helloDataObject);

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '/' . $this->currentHelloWorld->getId(),
                'httpMethod' => Request::HTTP_METHOD_GET,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . 'Get',
            ],
        ];

        $hello = $this->_webApiCall($serviceInfo, [HelloWorldAPIInterface::ID => $this->currentHelloWorld->getId()]);
        $this->assertNotNull($hello['id']);

        /** @var HelloWorldAPIInterface $helloData */
        $helloData = $this->helloWorldRepository->get($hello['id']);
        $this->assertEquals($helloData->getContent(), $content);
    }

    /**
     * Test create HelloWorldAPIInterface
     */
    public function testCreate()
    {
        $content = 'Hello content';

        /** @var  HelloWorldAPIInterface $helloDataObject */
        $helloDataObject = $this->helloWorldAPIInterfaceFactory->create();
        $helloDataObject->setContent($content);

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . 'Save',
            ],
        ];

        $requestData = ['helloWorld' => [
            HelloWorldAPIInterface::CONTENT => $helloDataObject->getContent()
        ]
        ];
        $hello = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertNotNull($hello['id']);
        $this->currentHelloWorld = $this->helloWorldRepository->get($hello['id']);
        $this->assertEquals($this->currentHelloWorld->getContent(), $content);
    }
}
