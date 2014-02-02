<?php

namespace Propertyguru\MustacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PropertyguruMustacheExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        // Load defaults config values
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');


        // Get the configuration
        $bundleConfiguration = $this->getConfiguration($config, $container);
        $config = $this->processConfiguration($bundleConfiguration, $config);

        $mustacheEngine = $container->getDefinition('templating.engine.mustache');
        $mustacheEngine->addMethodCall('addExtensions', array($config['extensions']));
    }
}
