<?php

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use SymfonySkillbox\HomeworkBundle\UnitProviderInterface;

class SymfonySkillboxHomeworkExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(UnitProviderInterface::class)
            ->addTag('symfony_skillbox_homework.unit_provider');

        if (null !== $config['strategy']) {
            $container->setAlias('symfony_skillbox_homework.strategy', $config['strategy']);
        }
    }

    public function getAlias(): string
    {
        return 'symfony_skillbox_homework';
    }
}
