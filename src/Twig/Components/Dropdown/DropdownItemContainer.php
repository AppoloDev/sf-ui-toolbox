<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Dropdown;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class DropdownItemContainer
{
    public bool $allowDisplay = true;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['allowDisplay' => true]);
        $resolver->setAllowedTypes('allowDisplay', ['bool', 'null']);

        return $resolver->resolve($data);
    }
}