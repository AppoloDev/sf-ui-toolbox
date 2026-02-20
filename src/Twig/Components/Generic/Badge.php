<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Generic;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Badge
{
    public string|int $label;
    public string $color = 'gray';
    public string $rounded = 'default';
}