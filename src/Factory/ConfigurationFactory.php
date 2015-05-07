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

use ProxyManager\Autoloader\AutoloaderInterface;
use ProxyManager\Configuration as ProxyConfiguration;
use ProxyManager\GeneratorStrategy\GeneratorStrategyInterface;
use ProxyManager\Inflector\ClassNameInflectorInterface;
use ProxyManager\Signature\ClassSignatureGeneratorInterface;
use ProxyManager\Signature\SignatureCheckerInterface;
use ProxyManager\Signature\SignatureGeneratorInterface;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConfigurationFactory.
 */
class ConfigurationFactory implements FactoryInterface
{
    /**
     * Create service.
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ProxyConfiguration
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if (!array_key_exists('proxy_manager_module', $config)) {
            throw new Exception\InvalidArgumentException('Missing "proxy_manager_module" config key');
        }
        $proxyConfig = $config['proxy_manager_module'];

        if (!array_key_exists('configuration', $proxyConfig)) {
            throw new Exception\InvalidArgumentException(
                'Missing "configuration" config key in "proxy_manager_module"'
            );
        }

        $factoryConfig = new ProxyConfiguration();
        $this->setConfigurationConfig($serviceLocator, $factoryConfig, $proxyConfig['configuration']);

        return $factoryConfig;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param ProxyConfiguration      $factoryConfig
     * @param array                   $config
     *
     * @return ProxyConfiguration
     */
    protected function setConfigurationConfig(
        ServiceLocatorInterface $serviceLocator,
        ProxyConfiguration $factoryConfig,
        array $config
    ) {
        if (array_key_exists('proxies_namespace', $config)) {
            $factoryConfig->setProxiesNamespace($config['proxies_namespace']);
        }

        if (array_key_exists('proxies_target_dir', $config)) {
            $factoryConfig->setProxiesTargetDir($config['proxies_target_dir']);
        }

        if (array_key_exists('generator_strategy', $config)) {
            $strategy = $config['generator_strategy'];
            if (is_string($strategy)) {
                /** @var GeneratorStrategyInterface $strategy */
                $strategy = $serviceLocator->get($strategy);
            }
            $factoryConfig->setGeneratorStrategy($strategy);
        }

        if (array_key_exists('proxy_autoloader', $config)) {
            $autoloader = $config['proxy_autoloader'];
            if (is_string($autoloader)) {
                /** @var AutoloaderInterface $autoloader */
                $autoloader = $serviceLocator->get($autoloader);
            }
            $factoryConfig->setProxyAutoloader($autoloader);
        }

        if (array_key_exists('class_name_inflector', $config)) {
            $inflector = $config['class_name_inflector'];
            if (is_string($inflector)) {
                /** @var ClassNameInflectorInterface $inflector */
                $inflector = $serviceLocator->get($inflector);
            }
            $factoryConfig->setClassNameInflector($inflector);
        }

        if (array_key_exists('signature_generator', $config)) {
            $signatureGenerator = $config['signature_generator'];
            if (is_string($signatureGenerator)) {
                /** @var SignatureGeneratorInterface $signatureGenerator */
                $signatureGenerator = $serviceLocator->get($signatureGenerator);
            }
            $factoryConfig->setSignatureGenerator($signatureGenerator);
        }

        if (array_key_exists('signature_checker', $config)) {
            $signatureChecker = $config['signature_checker'];
            if (is_string($signatureChecker)) {
                /** @var SignatureCheckerInterface $signatureChecker */
                $signatureChecker = $serviceLocator->get($signatureChecker);
            }
            $factoryConfig->setSignatureChecker($signatureChecker);
        }

        if (array_key_exists('class_signature_generator', $config)) {
            $classSignatureChecker = $config['class_signature_generator'];
            if (is_string($classSignatureChecker)) {
                /** @var ClassSignatureGeneratorInterface $classSignatureChecker */
                $classSignatureChecker = $serviceLocator->get($classSignatureChecker);
            }
            $factoryConfig->setClassSignatureGenerator($classSignatureChecker);
        }

        return $factoryConfig;
    }
}
