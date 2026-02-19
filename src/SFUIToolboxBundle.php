<?php

namespace AppoloDev\SFUIToolboxBundle;

use AppoloDev\SFUIToolboxBundle\DependencyInjection\SFUIToolboxExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SFUIToolboxBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SFUIToolboxExtension();
    }
}
