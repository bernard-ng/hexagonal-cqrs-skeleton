<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\SqlQuery;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Exception\InvalidArgument;
use Reformo\Common\Services\Persistence\SqlQuery;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Persistence\Doctrine\ResultObject\User;
use Throwable;
use function array_key_exists;
use function count;
use function sprintf;

final class GetUserById
{
    use SqlQuery;

    private static $sql = <<<SQL
        SELECT *
          FROM users
         WHERE id=:userId
SQL;

    public static function execute(Connection $connection, array $parameters) : ?User
    {
        if (! array_key_exists('userId', $parameters)) {
            throw InvalidArgument::create('Query needs parameter named: userId');
        }
        $query     = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $records = $statement->fetchAll(FetchMode::CUSTOM_OBJECT, User::class);
            if (count($records) === 0) {
                throw UserNotFound::create(sprintf('User not found by id: %s', $parameters['userId']));
            }

            return $records[0];
        } catch (Throwable $exception) {
            if ($exception instanceof  UserNotFound) {
                throw $exception;
            }
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}
