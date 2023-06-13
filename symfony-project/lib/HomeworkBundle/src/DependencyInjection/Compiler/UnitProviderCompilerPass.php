<?php

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UnitProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('symfony_skillbox_homework.unit_factory');

        if (! $container->findTaggedServiceIds('symfony_skillbox_homework.unit_provider')) {
            $definition->setArgument(1, [new Reference('symfony_skillbox_homework.base_unit')]);
        }
    }
}
