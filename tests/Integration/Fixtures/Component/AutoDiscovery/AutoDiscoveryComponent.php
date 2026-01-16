<?php

namespace Tito10047\UxTwigComponentAsset\Tests\Integration\Fixtures\Component\AutoDiscovery;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Tito10047\UxTwigComponentAsset\Attribute\Asset;

#[AsTwigComponent('AutoDiscoveryComponent')]
#[Asset]
class AutoDiscoveryComponent
{
}
