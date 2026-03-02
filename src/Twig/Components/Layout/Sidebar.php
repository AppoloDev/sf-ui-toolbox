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
     * Each entry is either a flat link or a group:
     *   Flat:  {label, route, params?, isGranted, icon}
     *   Group: {label, icon, isGranted, children: [{label, route, params?, isGranted, icon}, ...]}
     *
     * @param array<int, array<string, mixed>> $mainLinks
     */
    public function mount(array $mainLinks = []): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentRoute = $request?->attributes->get('_route') ?? '';

        $this->processedLinks = array_map(function (array $link) use ($request, $currentRoute): array {
            if (isset($link['children'])) {
                $link['children'] = array_map(
                    fn (array $child): array => $this->resolveActive($child, $request, $currentRoute),
                    $link['children']
                );
                $link['isOpen'] = [] !== array_filter($link['children'], fn (array $c): bool => $c['isActive']);

                return $link;
            }

            return $this->resolveActive($link, $request, $currentRoute);
        }, $mainLinks);
    }

    /**
     * @param array<string, mixed> $link
     *
     * @return array<string, mixed>
     */
    private function resolveActive(array $link, ?\Symfony\Component\HttpFoundation\Request $request, string $currentRoute): array
    {
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
    }
}
