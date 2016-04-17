<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManagerModule\Factory\ConfigurationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

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

        $serviceLocator = $this->getMockBuilder(ServiceLocatorInterface::class)
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

        $serviceLocator->expects(static::any())
            ->method('get')
            ->will(static::returnValueMap([
                ['config', $config],
                ['ProxyAutoloader', $proxyAutoloader],
                ['GeneratorStrategy', $generatorStrategy],
                ['ClassNameInflector', $classNameInflector],
                ['SignatureGenerator', $signatureGenerator],
                ['SignatureChecker', $signatureChecker],
                ['ClassSignatureGenerator', $classSignatureGenerator]
            ]));

        $factory = new ConfigurationFactory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        /** @var \ProxyManager\Configuration $configuration */
        $configuration = $factory->createService($serviceLocator);

        static::assertEquals('ProxyNamespaceTest', $configuration->getProxiesNamespace());
        static::assertEquals('./data/ProxyManagerTestDir', $configuration->getProxiesTargetDir());
        static::assertEquals($generatorStrategy, $configuration->getGeneratorStrategy());
        static::assertEquals($proxyAutoloader, $configuration->getProxyAutoloader());
        static::assertEquals($classNameInflector, $configuration->getClassNameInflector());
        static::assertEquals($signatureGenerator, $configuration->getSignatureGenerator());
        static::assertEquals($signatureChecker, $configuration->getSignatureChecker());
        static::assertEquals($classSignatureGenerator, $configuration->getClassSignatureGenerator());
    }

    /**
     * @expectedException        \Zend\ServiceManager\Exception\InvalidArgumentException
     * @expectedExceptionMessage Missing "proxy_manager_module" config key
     */
    public function testCreateServiceWithoutRootKey()
    {
        $config = [];
        $serviceLocator = $this->getMockBuilder(ServiceLocatorInterface::class)
            ->getMock();
        $serviceLocator->expects(static::any())
            ->method('get')
            ->will(static::returnValueMap([
                ['config', $config]
            ]));

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
        $serviceLocator = $this->getMockBuilder(ServiceLocatorInterface::class)
            ->getMock();
        $serviceLocator->expects(static::any())
            ->method('get')
            ->will(static::returnValueMap([
                ['config', $config]
            ]));

        $factory = new ConfigurationFactory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        $factory->createService($serviceLocator);
    }
}
