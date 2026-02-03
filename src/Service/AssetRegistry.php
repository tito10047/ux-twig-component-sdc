<?php

/*
 * This file is part of the UX SDC Bundle
 *
 * (c) Jozef Môstka <https://github.com/tito10047/ux-sdc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tito10047\UX\Sdc\Service;

final class AssetRegistry
{
    /**
     * @var array<string, array{path: string, type: string, priority: int, attributes: array<string, mixed>}>
     */
    private array $assets = [];

    /**
     * @param array<string, mixed> $attributes
     */
    public function addAsset(string $path, string $type, int $priority = 0, array $attributes = []): void
    {
        $key = $path . '|' . $type;
        if (!empty($attributes)) {
            $key .= '|' . serialize($attributes);
        }

        if (!isset($this->assets[$key])) {
            $this->assets[$key] = [
                'path' => $path,
                'type' => $type,
                'priority' => $priority,
                'attributes' => $attributes,
            ];
        } else {
            // Ak už existuje, môžeme aktualizovať prioritu na vyššiu
            if ($priority > $this->assets[$key]['priority']) {
                $this->assets[$key]['priority'] = $priority;
            }
        }
    }

    /**
     * @return array<int, array{path: string, type: string, priority: int, attributes: array<string, mixed>}>
     */
    public function getSortedAssets(): array
    {
        $sorted = array_values($this->assets);

        usort($sorted, function ($a, $b) {
            return $b['priority'] <=> $a['priority'];
        });

        return $sorted;
    }

    public function clear(): void
    {
        $this->assets = [];
    }
}
