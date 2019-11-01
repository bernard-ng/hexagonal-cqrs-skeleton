<?php

declare(strict_types=1);

namespace Reformo\Common;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;
use Reformo\Common\Interfaces\Identifier;

trait IdentifierTrait
{
    private $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function createFromString(string $uuid) : Identifier
    {
        Assert::uuid($uuid, 'Invalid uuid provided!');
        return new self(Uuid::fromString($uuid));
    }

    public static function createFromUuidObject(UuidInterface $uuid) : self
    {
        Assert::uuid($uuid->toString(), 'Invalid uuid object provided!');

        return new self($uuid);
    }

    public function id() : UuidInterface
    {
        return $this->id;
    }

    public function toString() : string
    {
        return $this->id->toString();
    }
}
