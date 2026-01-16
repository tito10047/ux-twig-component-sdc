<?php

namespace Tito10047\UxTwigComponentAsset\Tests\Integration\Fixtures\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Tito10047\UxTwigComponentAsset\Attribute\Asset;

#[AsTwigComponent('TestComponent', template: 'components/TestComponent.html.twig')]
#[Asset(path: 'css/test.css')]
#[Asset(path: 'js/test.js')]
class TestComponent
{
}
