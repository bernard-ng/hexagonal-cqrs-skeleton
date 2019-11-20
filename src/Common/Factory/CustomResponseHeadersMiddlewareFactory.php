<?php

declare(strict_types=1);

namespace Reformo\Common\Factory;

use Interop\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Reformo\Common\Middleware\CustomResponseHeadersMiddleware;
use Zend\ServiceManager\Factory\FactoryInterface;

class CustomResponseHeadersMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) : MiddlewareInterface
    {
        $config        = $container->get('config');
        $customHeaders = $config['http']['response']['custom-headers'] ?? [];

        return new CustomResponseHeadersMiddleware($customHeaders);
    }
}
