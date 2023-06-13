<?php

namespace SymfonySkillbox\HomeworkBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonySkillbox\HomeworkBundle\DependencyInjection\Compiler\UnitProviderCompilerPass;
use SymfonySkillbox\HomeworkBundle\DependencyInjection\SymfonySkillboxHomeworkExtension;

class SymfonySkillboxHomeworkBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new SymfonySkillboxHomeworkExtension();
        }

        return $this->extension;
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new UnitProviderCompilerPass());
    }
}
