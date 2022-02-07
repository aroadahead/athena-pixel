<?php

namespace AthenaPixel\Service\Listener\Factory;

use AthenaPixel\Service\Listener\LoadNavigationListener;
use Interop\Container\ContainerInterface;

class LoadNavigationListenerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LoadNavigationListener($container);
    }
}