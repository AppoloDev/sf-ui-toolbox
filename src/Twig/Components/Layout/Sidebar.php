<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Layout;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Sidebar
{
    public string $routePrefix = '';
    public array $mainLinks = [];
    public ?string $userName = null;
    public ?string $userRole = null;
    public ?string $userInitials = null;
    public array $processedLinks = [];

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function mount(): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentRoute = $request?->attributes->get('_route') ?? '';

        $this->processedLinks = array_map(function (array $link) use ($request, $currentRoute): array {
            $isActive = $currentRoute === ($link['route'] ?? '');

            if ($isActive && isset($link['params'])) {
                foreach ($link['params'] as $key => $value) {
                    if ($request?->query->get($key) !== $value) {
                        $isActive = false;
                        break;
                    }
                }
            }

            $link['isActive'] = $isActive;

            return $link;
        }, $this->mainLinks);
    }
}
