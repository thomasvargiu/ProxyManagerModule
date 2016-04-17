<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManagerModule\Factory\ConfigurationFactory;
use Zend\ServiceManager\ServiceManager;

class ConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $config = [
            'proxy_manager_module' => [
                'configuration' => [
                    'proxies_namespace' => 'ProxyNamespaceTest',
                    'proxies_target_dir' => './data/ProxyManagerTestDir',
                    'generator_strategy' => 'GeneratorStrategy',
                    'proxy_autoloader' => 'ProxyAutoloader',
                    'class_name_inflector' => 'ClassNameInflector',
                    'signature_generator' => 'SignatureGenerator',
                    'signature_checker' => 'SignatureChecker',
                    'class_signature_generator' => 'ClassSignatureGenerator'
                ]
            ]
        ];

        $serviceLocator = $this->getMockBuilder(ServiceManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $generatorStrategy = $this->getMockBuilder(\ProxyManager\GeneratorStrategy\GeneratorStrategyInterface::class)
            ->getMock();

        $proxyAutoloader = $this->getMockBuilder(\ProxyManager\Autoloader\AutoloaderInterface::class)
            ->getMock();

        $classNameInflector = $this->getMockBuilder(\ProxyManager\Inflector\ClassNameInflectorInterface::class)
            ->getMock();

        $signatureGenerator = $this->getMockBuilder(\ProxyManager\Signature\SignatureGeneratorInterface::class)
            ->getMock();

        $signatureChecker = $this->getMockBuilder(\ProxyManager\Signature\SignatureCheckerInterface::class)
            ->getMock();

        $classSignatureGenerator =
            $this->getMockBuilder(\ProxyManager\Signature\ClassSignatureGeneratorInterface::class)
            ->getMock();

        $serviceMap = [
            'config' => $config,
            'ProxyAutoloader' => $proxyAutoloader,
            'GeneratorStrategy' => $generatorStrategy,
            'ClassNameInflector' => $classNameInflector,
            'SignatureGenerator' => $signatureGenerator,
            'SignatureChecker' => $signatureChecker,
            'ClassSignatureGenerator' => $classSignatureGenerator
        ];

        $serviceLocator->expects(static::any())
            ->method('get')
            ->will(static::returnCallback(function($name) use ($serviceMap) {
                return $serviceMap[$name] ?? null;
            }));

        $factory = new ConfigurationFactory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        /** @var \ProxyManager\Configuration $configuration */
        $configuration = $factory->createService($serviceLocator);

        static::assertEquals('ProxyNamespaceTest', $configuration->getProxiesNamespace());
        static::assertEquals('./data/ProxyManagerTestDir', $configuration->getProxiesTargetDir());
        static::assertSame($generatorStrategy, $configuration->getGeneratorStrategy());
        static::assertSame($proxyAutoloader, $configuration->getProxyAutoloader());
        static::assertSame($classNameInflector, $configuration->getClassNameInflector());
        static::assertSame($signatureGenerator, $configuration->getSignatureGenerator());
        static::assertSame($signatureChecker, $configuration->getSignatureChecker());
        static::assertSame($classSignatureGenerator, $configuration->getClassSignatureGenerator());
    }

    /**
     * @expectedException        \Zend\ServiceManager\Exception\InvalidArgumentException
     * @expectedExceptionMessage Missing "proxy_manager_module" config key
     */
    public function testCreateServiceWithoutRootKey()
    {
        $config = [];
        $serviceLocator = $this->getMockBuilder(ServiceManager::class)
            ->getMock();
        $serviceLocator->expects(static::atLeastOnce())
            ->method('get')
            ->with('config')
            ->willReturn($config);

        $factory = new ConfigurationFactory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        $factory->createService($serviceLocator);
    }

    /**
     * @expectedException        \Zend\ServiceManager\Exception\InvalidArgumentException
     * @expectedExceptionMessage Missing "configuration" config key in "proxy_manager_module"
     */
    public function testCreateServiceWithoutConfigurationKey()
    {
        $config = [
            'proxy_manager_module' => []
        ];
        $serviceLocator = $this->getMockBuilder(ServiceManager::class)
            ->getMock();
        $serviceLocator->expects(static::atLeastOnce())
            ->method('get')
            ->with('config')
            ->willReturn($config);

        $factory = new ConfigurationFactory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        $factory->createService($serviceLocator);
    }
}
