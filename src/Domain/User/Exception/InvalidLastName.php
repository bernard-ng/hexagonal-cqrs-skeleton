<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Exception;

use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;
use Reformo\Domain\DomainException;
use Exception;

class InvalidLastName extends Exception implements ProblemDetailsExceptionInterface
{
    use DomainException;

    protected const STATUS = 400;
    protected const CODE   = 'USER-1002';
    protected const TYPE   = 'https://httpstatus.es/400';
    protected const TITLE  = 'Invalid last name';
}
