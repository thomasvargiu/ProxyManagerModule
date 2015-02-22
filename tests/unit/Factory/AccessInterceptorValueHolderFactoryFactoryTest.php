<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManager\Configuration;
use ProxyManagerModule\Factory\AccessInterceptorValueHolderFactoryFactory as Factory;

class AccessInterceptorValueHolderFactoryFactoryTest extends \PHPUnit_Framework_TestCase
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

        $this->assertInstanceOf('ProxyManager\\Factory\\AccessInterceptorValueHolderFactory', $proxyFactory);
    }
}
