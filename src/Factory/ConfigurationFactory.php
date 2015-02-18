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

namespace ProxyManagerModule\Factory;

use ProxyManager\Configuration as ProxyConfiguration;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigurationFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if (!isset($config['proxy_manager_factory'])) {
            throw new Exception\InvalidArgumentException('Missing "proxy_manager_factory" config key');
        }
        $proxyConfig = $config['proxy_manager_factory'];

        if (!isset($proxyConfig['configuration'])) {
            throw new Exception\InvalidArgumentException(
                'Missing "configuration" config key in "proxy_manager_factory"'
            );
        }

        $factoryConfig = new ProxyConfiguration();
        if (isset($proxyConfig['configuration'])) {
            $this->setConfigurationConfig($serviceLocator, $factoryConfig, $proxyConfig['configuration']);
        }
        return $factoryConfig;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param ProxyConfiguration      $factoryConfig
     * @param array                   $config
     * @return ProxyConfiguration
     */
    protected function setConfigurationConfig(
        ServiceLocatorInterface $serviceLocator,
        ProxyConfiguration $factoryConfig,
        array $config
    )
    {
        if (isset($config['proxies_namespace'])) {
            $factoryConfig->setProxiesNamespace($config['proxies_namespace']);
        }

        if (isset($config['proxies_target_dir'])) {
            $factoryConfig->setProxiesTargetDir($config['proxies_target_dir']);
        }

        if (isset($config['generator_strategy'])) {
            $strategy = $config['generator_strategy'];
            if (!is_object($strategy)) {
                $strategy = $serviceLocator->get($strategy);
            }
            $factoryConfig->setGeneratorStrategy($strategy);
        }

        if (isset($config['proxy_autoloader'])) {
            $autoloader = $config['proxy_autoloader'];
            if (!is_object($autoloader)) {
                $autoloader = $serviceLocator->get($autoloader);
            }
            $factoryConfig->setProxyAutoloader($autoloader);
        }

        if (isset($config['class_name_inflector'])) {
            $inflector = $config['class_name_inflector'];
            if (!is_object($inflector)) {
                $inflector = $serviceLocator->get($inflector);
            }
            $factoryConfig->setClassNameInflector($inflector);
        }

        return $factoryConfig;
    }
}
