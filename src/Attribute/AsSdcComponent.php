<?php

/*
 * This file is part of the UX SDC Bundle
 *
 * (c) Jozef Môstka <https://github.com/tito10047/ux-sdc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tito10047\UX\Sdc\Attribute;

use Attribute;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[Attribute(Attribute::TARGET_CLASS)]
class AsSdcComponent extends AsTwigComponent
{
    public function __construct(
        ?string $name = null,
        ?string $template = null,
        bool $exposePublicProps = true,
        string $attributesVar = 'attributes',
        public ?string $css = null,
        public ?string $js = null,
    ) {
        parent::__construct($name, $template, $exposePublicProps, $attributesVar);
    }
}
