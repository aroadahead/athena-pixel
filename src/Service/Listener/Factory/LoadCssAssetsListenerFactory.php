<?php

namespace AthenaPixel\Service\Listener\Factory;

use AthenaPixel\Service\Listener\LoadCssAssetsListener;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LoadCssAssetsListenerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LoadCssAssetsListener($container);
    }
}