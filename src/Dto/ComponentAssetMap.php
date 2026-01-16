<?php

namespace Tito10047\UxTwigComponentAsset\Dto;

final class ComponentAssetMap
{
    /**
     * @param array<string, array<int, array{path: string, type: string, priority: int, attributes: array}>> $map
     */
    public function __construct(
        private array $map = []
    ) {
    }

    public function getAssetsForComponent(string $componentName): array
    {
        return $this->map[$componentName] ?? [];
    }

    public function getMap(): array
    {
        return $this->map;
    }
}
