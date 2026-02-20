<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Generic;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Breadcrumb
{
    public array $items = [];
}