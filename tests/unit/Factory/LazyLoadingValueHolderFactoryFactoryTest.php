<?php

namespace ProxyManagerModuleTest\Factory;

use ProxyManager\Configuration;
use ProxyManagerModule\Factory\LazyLoadingValueHolderFactoryFactory as Factory;

class LazyLoadingValueHolderFactoryFactoryTest extends \PHPUnit_Framework_TestCase
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

        $factory = new Factory();

        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
        $proxyFactory = $factory->createService($serviceLocator);

        static::assertInstanceOf('ProxyManager\\Factory\\LazyLoadingValueHolderFactory', $proxyFactory);
    }
}
