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

final class GetUserByEmail
{
    use SqlQuery;

    private static $sql = <<<SQL
        SELECT *
          FROM users
         WHERE email = :email
         LIMIT 1
SQL;

    public static function execute(Connection $connection, array $parameters) : User
    {
        if (! array_key_exists('email', $parameters)) {
            throw InvalidArgument::create('Query needs parameter named: email');
        }
        $query     = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $records = $statement->fetchAll(FetchMode::CUSTOM_OBJECT, User::class);
            if (count($records) === 0) {
                throw UserNotFound::create(sprintf('User not found by email: %s', $parameters['email']));
            }

            return $records[0];
        } catch (UserNotFound $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}
