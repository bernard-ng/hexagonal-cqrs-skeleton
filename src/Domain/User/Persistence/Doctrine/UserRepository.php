<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Reformo\Domain\User\Interfaces\UserId;
use Reformo\Domain\User\Interfaces\UserRepository as UserRepositoryInterface;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Model\UsersCollection;
use Reformo\Domain\User\Persistence\Doctrine\Query\AddUser;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetAllUsers;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserById;

class UserRepository implements UserRepositoryInterface
{
    private const TABLE_NAME = 'users';
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function get(UserId $userId) : User
    {
        return GetUserById::execute($this->connection, ['userId' => $userId->toString()]);
    }

    public function add(User $user) : bool
    {
        return AddUser::execute($this->connection, $user) > 0;
    }

    public function getAllUsersPaginated(int $offset, int $limit) : UsersCollection
    {
        return GetAllUsers::execute($this->connection, ['offset' => $offset, 'limit' => $limit]);
    }
}
