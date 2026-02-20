<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Generic;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Alert
{
    public ?string $header = null;
    public string $color = 'green';
    public ?string $description = null;
    public array $links = [];
}