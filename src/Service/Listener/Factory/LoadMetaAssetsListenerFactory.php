<?php

namespace AthenaPixel\Service\Listener\Factory;

use AthenaPixel\Service\Listener\LoadMetaAssetsListener;
use Interop\Container\ContainerInterface;

class LoadMetaAssetsListenerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LoadMetaAssetsListener($container);
    }
}