<?php

namespace Propertyguru\MustacheBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Propertyguru\MustacheBundle\DependencyInjection\Compiler\MustacheHelperPass;

class PropertyguruMustacheBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MustacheHelperPass());
    }
}
