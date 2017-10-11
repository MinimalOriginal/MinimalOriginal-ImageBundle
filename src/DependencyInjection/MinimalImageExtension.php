<?php

namespace MinimalOriginal\ImageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

class MinimalImageExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $file = __DIR__.'/../Resources/config/liip_config.yml';
        $liip_config = Yaml::parse(file_get_contents($file));

        $file = __DIR__.'/../Resources/config/knp_gaufrette_config.yml';
        $knp_gaufrette_config = Yaml::parse(file_get_contents($file));

        $file = __DIR__.'/../Resources/config/ivory_ck_editor_config.yml';
        $ivory_ck_editor_config = Yaml::parse(file_get_contents($file));

        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'liip_imagine':
                    $container->prependExtensionConfig($name, $liip_config);
                    break;
                case 'knp_gaufrette':
                    $container->prependExtensionConfig($name, $knp_gaufrette_config);
                    break;
                case 'ivory_ck_editor':
                    $container->prependExtensionConfig($name, $ivory_ck_editor_config);
                    break;
            }
        }
    }
}
