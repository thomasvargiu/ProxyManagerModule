<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManager\Configuration;
use ProxyManagerModule\Factory\LazyLoadingGhostFactoryFactory as Factory;

class LazyLoadingGhostFactoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $configuration = new Configuration();

        $serviceLocator = $this->getMockBuilder('Zend\\ServiceManager\\ServiceLocatorInterface')
            ->getMock();

        $serviceLocator->expects($this->once())
            ->method('get')
            ->with($this->equalTo('ProxyManager\\Configuration'))
            ->will($this->returnValue($configuration));

        $factory = new Factory();

        $proxyFactory = $factory->createService($serviceLocator);

        $this->assertInstanceOf('ProxyManager\\Factory\\LazyLoadingGhostFactory', $proxyFactory);
    }
}
