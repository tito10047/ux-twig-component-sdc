<?php

namespace Tito10047\UxTwigComponentAsset\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ux_twig_component_asset');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('auto_discovery')
                    ->defaultTrue()
                    ->info('Či sa majú automaticky hľadať asety v adresári komponentu.')
                ->end()
                ->scalarNode('placeholder')
                    ->defaultValue('<!-- __UX_TWIG_COMPONENT_ASSETS__ -->')
                    ->info('Placeholder v HTML, ktorý bude nahradený asetikami.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
