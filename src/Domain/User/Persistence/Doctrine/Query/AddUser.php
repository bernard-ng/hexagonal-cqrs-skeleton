<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Reformo\Common\Exception\InvalidArgument;
use Reformo\Common\Query;
use Reformo\Domain\User\Model\User;

final class AddUser
{
    use Query;

    public static function execute(Connection $connection, User $user) : int
    {
        if (! $user instanceof User) {
            throw InvalidArgument::create('Provided data is not a User object!');
        }

        return $connection->insert('users', [
            'id' => $user->id()->toString(),
            'email' => $user->email()->toString(),
            'first_name' => $user->firstName(),
            'last_name' => $user->lastName(),
            'created_at' => $user->createdAt()->format(User::CREATED_AT_FORMAT),
        ]);
    }
}
