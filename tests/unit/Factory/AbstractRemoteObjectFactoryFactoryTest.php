<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManager\Configuration;

class AbstractRemoteObjectFactoryFactoryTest extends \PHPUnit_Framework_TestCase
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

        $adapter = $this->getMockBuilder('ProxyManager\\Factory\\RemoteObject\\AdapterInterface')
            ->getMock();

        $factory = $this->getMockForAbstractClass('ProxyManagerModule\\Factory\\AbstractRemoteObjectFactoryFactory');

        $factory->expects($this->once())
            ->method('getAdapter')
            ->will($this->returnValue($adapter));

        $proxyFactory = $factory->createService($serviceLocator);

        $this->assertInstanceOf('ProxyManager\\Factory\\RemoteObjectFactory', $proxyFactory);
    }
}
