<?php

declare(strict_types=1);

namespace Reformo\Common\Exception;

use Exception;
use Reformo\Domain\DomainException;
use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class InvalidParameter extends Exception implements ProblemDetailsExceptionInterface
{
    use DomainException;

    private const STATUS = 400;
    private const CODE   = 'G-1000';
    private const TYPE   = 'https://httpstatus.es/400';
    private const TITLE  = 'Invalid parameter.';
}
