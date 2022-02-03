<?php

namespace AthenaPixel\Service\Listener\Factory;

use AthenaPixel\Service\Listener\LoadJsAssetsListener;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class LoadJsAssetsListenerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LoadJsAssetsListener($container);
    }
}