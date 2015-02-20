# ProxyManagerModule

**Status: development**

ZF2 module that allows simplified use of [Ocramius/ProxyManager](https://github.com/Ocramius/ProxyManager) registering factories in the service manager.

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
