<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Generic;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Toast
{
    public string $message;
    public string $type = 'success';
}