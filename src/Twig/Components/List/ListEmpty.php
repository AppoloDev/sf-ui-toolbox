<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\List;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class ListEmpty
{
    public string $title = 'Aucun résultat.';
    public ?string $description = 'Essayez d\'ajouter un nouvel élément.';
}