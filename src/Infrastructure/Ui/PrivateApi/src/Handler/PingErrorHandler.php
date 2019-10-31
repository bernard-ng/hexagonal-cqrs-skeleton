<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\Tactician\CommandBus;
use Reformo\Application\ExampleException;


class PingErrorHandler implements RequestHandlerInterface
{
    private $config;
    private $commandBus;

    public function __construct(
        CommandBus $commandBus,
        array $config
    ) {
        $this->config     = $config;
        $this->commandBus = $commandBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        throw ExampleException::create(['code' => 'AD-1224']);
    }
}
