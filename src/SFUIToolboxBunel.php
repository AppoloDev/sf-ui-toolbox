<?php

namespace AppoloDev\SFUIToolboxBundle;

use AppoloDev\SFToolboxBundle\DependencyInjection\SFUIToolboxExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SFToolboxBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SFUIToolboxExtension();
    }
}
