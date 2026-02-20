<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Form;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class FormSubmit
{
    public ?FormView $form = null;
    public string $submitField = 'submit';
    public ?string $deleteButtonLink = null;
    public string $deleteSwalTitle = 'Êtes-vous sûr ?';
    public string $deleteSwalText = 'Vous êtes sur le point d\'effectuer une action totalement irréversible …';
    public string $deleteSwalColor = 'red';
}