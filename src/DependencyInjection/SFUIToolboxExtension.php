<?php

namespace AppoloDev\SFUIToolboxBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SFUIToolboxExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        /** @var array $bundles */
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['TwigBundle'])) {
            $container->prependExtensionConfig('twig', [
                'paths' => [
                    __DIR__.'/../../templates' => 'SFUIToolbox',
                ],
            ]);
        }

        if (isset($bundles['TwigComponentBundle'])) {
            $container->prependExtensionConfig('twig_component', [
                'defaults' => [
                    'AppoloDev\\SFUIToolboxBundle\\Twig\\Components\\' => [
                        'template_directory' => '@SFUIToolbox/components/',
                        'name_prefix' => 'SFUIToolbox',
                    ],
                ],
            ]);
        }

        if (isset($bundles['KnpPaginatorBundle'])) {
            $container->prependExtensionConfig('knp_paginator', [
                'template' => [
                    'pagination' => '@SFUIToolbox/paginator/pagination.html.twig',
                ],
            ]);
        }
    }
}
