<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManagerModule\Factory\ConfigurationFactory;

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
                    'class_name_inflector' => 'ClassNameInflector'
                ]
            ]
        ];

        $serviceLocator = $this->getMockBuilder('Zend\\ServiceManager\\ServiceLocatorInterface')
            ->getMock();

        $generatorStrategy = $this->getMockBuilder('ProxyManager\\GeneratorStrategy\\GeneratorStrategyInterface')
            ->getMock();

        $proxyAutoloader = $this->getMockBuilder('ProxyManager\\Autoloader\\AutoloaderInterface')
            ->getMock();

        $classNameInflector = $this->getMockBuilder('ProxyManager\\Inflector\\ClassNameInflectorInterface')
            ->getMock();

        $serviceLocator->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                ['Config', $config],
                ['ProxyAutoloader', $proxyAutoloader],
                ['GeneratorStrategy', $generatorStrategy],
                ['ClassNameInflector', $classNameInflector]
            ]));

        $factory = new ConfigurationFactory();
        /** @var \ProxyManager\Configuration $configuration */
        $configuration = $factory->createService($serviceLocator);

        $this->assertEquals('ProxyNamespaceTest', $configuration->getProxiesNamespace());
        $this->assertEquals('./data/ProxyManagerTestDir', $configuration->getProxiesTargetDir());
        $this->assertEquals($generatorStrategy, $configuration->getGeneratorStrategy());
        $this->assertEquals($proxyAutoloader, $configuration->getProxyAutoloader());
        $this->assertEquals($classNameInflector, $configuration->getClassNameInflector());
    }

    /**
     * @expectedException        \Zend\ServiceManager\Exception\InvalidArgumentException
     * @expectedExceptionMessage Missing "proxy_manager_module" config key
     */
    public function testCreateServiceWithoutRootKey()
    {
        $config = [];
        $serviceLocator = $this->getMockBuilder('Zend\\ServiceManager\\ServiceLocatorInterface')
            ->getMock();
        $serviceLocator->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                ['Config', $config]
            ]));

        $factory = new ConfigurationFactory();
        /** @var \ProxyManager\Configuration $configuration */
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
        $serviceLocator = $this->getMockBuilder('Zend\\ServiceManager\\ServiceLocatorInterface')
            ->getMock();
        $serviceLocator->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                ['Config', $config]
            ]));

        $factory = new ConfigurationFactory();
        /** @var \ProxyManager\Configuration $configuration */
        $factory->createService($serviceLocator);
    }
}
