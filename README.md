# ProxyManagerModule

[![Build Status](https://scrutinizer-ci.com/g/thomasvargiu/ProxyManagerModule/badges/build.png?b=master)](https://scrutinizer-ci.com/g/thomasvargiu/ProxyManagerModule/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/thomasvargiu/ProxyManagerModule/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thomasvargiu/ProxyManagerModule/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thomasvargiu/ProxyManagerModule/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thomasvargiu/ProxyManagerModule/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/545f82008683321bc8000036/badge.svg?style=flat)](https://www.versioneye.com/user/projects/545f82008683321bc8000036)
[![Latest Stable Version](https://poser.pugx.org/thomasvargiu/proxy-manager-module/v/stable.svg)](https://packagist.org/packages/thomasvargiu/proxy-manager-module)
[![Total Downloads](https://poser.pugx.org/thomasvargiu/proxy-manager-module/downloads.svg)](https://packagist.org/packages/thomasvargiu/proxy-manager-module)
[![Latest Unstable Version](https://poser.pugx.org/thomasvargiu/proxy-manager-module/v/unstable.svg)](https://packagist.org/packages/thomasvargiu/proxy-manager-module)
[![License](https://poser.pugx.org/thomasvargiu/proxy-manager-module/license.svg)](https://packagist.org/packages/thomasvargiu/proxy-manager-module)

**Status: development**

Zend Framework module that allows simplified use of [Ocramius/ProxyManager](https://github.com/Ocramius/ProxyManager) registering factories in the service manager.

## Configuration ##

```php
return [
    'proxy_manager_module' => [
        'configuration' => [
            /*
             * Proxies namespace
             *
             * A namespace for proxies
             */
            // 'proxies_namespace' => '',

            /*
             * Proxies Target Directory
             *
             * Where to save proxies
             */
            // 'proxies_target_dir' => './data/ProxyManager',

            /*
             * Generator Strategy
             *
             * An instance of ProxyManager\GeneratorStrategy\GeneratorStrategyInterface
             * or a service name in the service locator
             */
            // 'generator_strategy' => '',

            /*
             * Proxy autoloader
             *
             * An instance of ProxyManager\Autoloader\AutoloaderInterface
             * or a service name in the service locator
             */
            // 'proxy_autoloader' => '',

            /*
             * Class name inflector
             *
             * An instance of ProxyManager\Inflector\ClassNameInflectorInterface
             * or a service name in the service locator
             */
            // 'class_name_inflector' => '',
        ],
    ],
];
```


## Registered Factories ##

```php
return [
    'service_manager' => [
        'factories' => [
            'ProxyManager\\Configuration' => 'ProxyManagerModule\\Factory\\ConfigurationFactory',
            'ProxyManager\\Factory\\AccessInterceptorScopeLocalizerFactory' => 'ProxyManagerModule\\Factory\\AccessInterceptorScopeLocalizerFactoryFactory',
            'ProxyManager\\Factory\\AccessInterceptorValueHolderFactory' => 'ProxyManagerModule\\Factory\\AccessInterceptorValueHolderFactoryFactory',
            'ProxyManager\\Factory\\LazyLoadingGhostFactory' => 'ProxyManagerModule\\Factory\\LazyLoadingGhostFactoryFactory',
            'ProxyManager\\Factory\\LazyLoadingValueHolderFactory' => 'ProxyManagerModule\\Factory\\LazyLoadingValueHolderFactoryFactory',
            'ProxyManager\\Factory\\NullObjectFactory' => 'ProxyManagerModule\\Factory\\NullObjectFactoryFactory',
        ],
    ],
];
```

### Configuration ###

- ```ProxyManager\Configuration```: Create the ProxyManager configuration from config

### Factories ###

These are factories created using configuration created by ```ProxyManager\Configuration``` service factory:

- ```ProxyManager\Factory\AccessInterceptorScopeLocalizerFactory```
- ```ProxyManager\Factory\AccessInterceptorValueHolderFactory```
- ```ProxyManager\Factory\LazyLoadingGhostFactory```
- ```ProxyManager\Factory\LazyLoadingValueHolderFactory```
- ```ProxyManager\Factory\NullObjectFactory```


## How to use ##

You can request a Proxy Factory by getting the factory via service manager.

```php
/** @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
$serviceLocator = $this->getServiceLocator();
/** @var \ProxyManager\Factory\LazyLoadingGhostFactory $proxyFactory */
$proxyFactory = $serviceLocator->get('ProxyManager\\Factory\\LazyLoadingGhostFactory');
```

Of course, you can register alias names in the ```service_manager``` config key.

## Version 2

The version 2 of this library is compatible with `zend-servicemanager` `^3.0` 
and updated for `ocramius/proxy-manager` `^2.0`.
