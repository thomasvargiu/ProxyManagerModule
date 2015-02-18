<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

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
    'service_manager' => [
        'factories' => [
            'ProxyManager\\Configuration' => 'ProxyManagerModule\\Factory\\ConfigurationFactory',
            'ProxyManager\\Factory\\AccessInterceptorScopeLocalizerFactory' =>
                'ProxyManagerModule\\Factory\\AccessInterceptorScopeLocalizerFactoryFactory',
            'ProxyManager\\Factory\\AccessInterceptorValueHolderFactory' =>
                'ProxyManagerModule\\Factory\\AccessInterceptorValueHolderFactoryFactory',
            'ProxyManager\\Factory\\LazyLoadingGhostFactory' =>
                'ProxyManagerModule\\Factory\\LazyLoadingGhostFactoryFactory',
            'ProxyManager\\Factory\\LazyLoadingValueHolderFactory' =>
                'ProxyManagerModule\\Factory\\LazyLoadingValueHolderFactoryFactory',
            'ProxyManager\\Factory\\NullObjectFactory' =>
                'ProxyManagerModule\\Factory\\NullObjectFactoryFactory',
        ],
    ],
];
