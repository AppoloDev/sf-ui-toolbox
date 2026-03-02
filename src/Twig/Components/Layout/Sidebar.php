<?php

namespace AppoloDev\SFUIToolboxBundle\Twig\Components\Layout;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Sidebar
{
    public string $routePrefix = '';
    public ?string $userName = null;
    public ?string $userRole = null;
    public ?string $userInitials = null;
    public array $processedLinks = [];

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * @param array<int, array{label: string, route: string, params?: array<string, string>, isGranted: bool, icon: string}> $mainLinks
     */
    public function mount(array $mainLinks = []): void
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
        }, $mainLinks);
    }
}
