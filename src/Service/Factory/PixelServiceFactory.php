<?php

declare(strict_types=1);

namespace AthenaPixel\Service\Factory;

use AthenaPixel\Service\PixelService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PixelServiceFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new PixelService($container);
    }
}