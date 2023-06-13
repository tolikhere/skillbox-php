<?php

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('symfony_skillbox_homework');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('strategy')
                    ->defaultNull()
                    ->info('Default unit production strategy by strength')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
