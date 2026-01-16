<?php

namespace Tito10047\UxTwigComponentAsset\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\UX\TwigComponent\Event\PreCreateForRenderEvent;
use Symfony\UX\TwigComponent\Event\PreRenderEvent;
use Tito10047\UxTwigComponentAsset\Dto\ComponentAssetMap;
use Tito10047\UxTwigComponentAsset\Service\AssetRegistry;

final class ComponentRenderListener
{
    public function __construct(
        private ComponentAssetMap $assetMap,
        private AssetRegistry $assetRegistry
    ) {
    }

    #[AsEventListener(event: PreCreateForRenderEvent::class)]
    public function onPreCreate(PreCreateForRenderEvent $event): void
    {
        $componentName = $event->getName();
        $assets = $this->assetMap->getAssetsForComponent($componentName);

        foreach ($assets as $asset) {
            $this->assetRegistry->addAsset(
                $asset['path'],
                $asset['type'] ?? (str_ends_with($asset['path'], '.css') ? 'css' : 'js'),
                $asset['priority'] ?? 0,
                $asset['attributes'] ?? []
            );
        }
    }

    #[AsEventListener(event: PreRenderEvent::class)]
    public function onPreRender(PreRenderEvent $event): void
    {
        $componentName = $event->getMetadata()->getName();
        $templatePath = $this->assetMap->getMap()[$componentName . '_template'] ?? null;

        if ($templatePath) {
            $event->setTemplate($templatePath);
        }
    }
}
