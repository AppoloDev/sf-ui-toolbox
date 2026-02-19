<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\List;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class TableList
{
    public ?string $headerTitle = null;
    public ?array $tableColumns = null;
    public ?PaginationInterface $pagination = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['headerTitle' => null]);
        $resolver->setAllowedTypes('headerTitle', ['string', 'null']);
        $resolver->setDefaults(['tableColumns' => null]);
        $resolver->setAllowedTypes('tableColumns', ['array', 'null']);
        $resolver->setDefaults(['pagination' => null]);
        $resolver->setAllowedTypes('pagination', [PaginationInterface::class, 'null']);

        return $resolver->resolve($data);
    }
}