<?php

namespace Tito10047\UxTwigComponentAsset;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

use Tito10047\UxTwigComponentAsset\CompilerPass\AssetComponentCompilerPass;

/**
 * @link https://symfony.com/doc/current/bundles/best_practices.html
 */
class UxTwigComponentAsset extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definition.php');
    }
    
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        $builder->getDefinition('Tito10047\UxTwigComponentAsset\EventListener\AssetResponseListener')
            ->setArgument('$placeholder', $config['placeholder']);

        $builder->getDefinition('Tito10047\UxTwigComponentAsset\Twig\AssetExtension')
            ->setArgument('$placeholder', $config['placeholder']);
            
        $builder->setParameter('ux_twig_component_asset.auto_discovery', $config['auto_discovery']);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new AssetComponentCompilerPass());
    }
}