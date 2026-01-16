<?php

namespace Tito10047\UxTwigComponentAsset\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;

class UxTwigComponentAssetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');

        $container->getDefinition('Tito10047\UxTwigComponentAsset\EventListener\AssetResponseListener')
            ->setArgument('$placeholder', $config['placeholder']);
            
        $container->setParameter('ux_twig_component_asset.auto_discovery', $config['auto_discovery']);
    }

    public function getAlias(): string
    {
        return 'ux_twig_component_asset';
    }
}
