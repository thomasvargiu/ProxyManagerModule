<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManager\Configuration;
use ProxyManagerModule\Factory\NullObjectFactoryFactory as Factory;
use Zend\ServiceManager\ServiceManager;

class NullObjectFactoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $configuration = new Configuration();

        $serviceLocator = $this->getMockBuilder(ServiceManager::class)
            ->getMock();

        $serviceLocator->expects(static::once())
            ->method('get')
            ->with(static::equalTo('ProxyManager\\Configuration'))
            ->will(static::returnValue($configuration));

        $factory = new Factory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        $proxyFactory = $factory->createService($serviceLocator);

        static::assertInstanceOf('ProxyManager\\Factory\\NullObjectFactory', $proxyFactory);
    }
}
