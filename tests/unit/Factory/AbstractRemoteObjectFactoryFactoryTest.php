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

        $serviceLocator->expects(static::once())
            ->method('get')
            ->with(static::equalTo('ProxyManager\\Configuration'))
            ->will(static::returnValue($configuration));

        $adapter = $this->getMockBuilder('ProxyManager\\Factory\\RemoteObject\\AdapterInterface')
            ->getMock();

        $factory = $this->getMockForAbstractClass('ProxyManagerModule\\Factory\\AbstractRemoteObjectFactoryFactory');

        $factory->expects(static::once())
            ->method('getAdapter')
            ->will(static::returnValue($adapter));

        /** @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        /** @var \ProxyManagerModule\Factory\AbstractRemoteObjectFactoryFactory $factory */
        $proxyFactory = $factory->createService($serviceLocator);

        static::assertInstanceOf('ProxyManager\\Factory\\RemoteObjectFactory', $proxyFactory);
    }
}
