<?php

/*
 * This file is part of the UX SDC Bundle
 *
 * (c) Jozef Môstka <https://github.com/tito10047/ux-sdc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tito10047\UX\Sdc\Runtime;

class SdcMetadataRegistry
{
    private ?array $metadata = null;

    public function __construct(
        private string $cachePath
    ) {
    }

    public function getMetadata(string $componentFccn): array|string|null
    {
        if (null === $this->metadata) {
            if (file_exists($this->cachePath)) {
                $this->metadata = require $this->cachePath;
            } else {
                $this->metadata = [];
            }
        }

        return $this->metadata[$componentFccn] ?? null;
    }
}
