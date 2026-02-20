<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Generic;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class BadgeYesNo
{
    public bool $value;
    public string $labelTrue = 'Oui';
    public string $labelFalse = 'Non';
    public string $rounded = 'default';
}