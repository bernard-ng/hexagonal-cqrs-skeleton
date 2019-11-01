<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Exception\InvalidParameter;
use Reformo\Common\Query;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Persistence\Doctrine\FetchObject\User as UserFetchObject;
use Throwable;
use function array_key_exists;

final class GetUserByEmail
{
    use Query;

    private static $sql = <<<SQL
        SELECT *
          FROM users
         WHERE email = :email
         LIMIT 1
SQL;

    public static function execute(Connection $connection, array $parameters) : User
    {
        if (! array_key_exists('email', $parameters)) {
            throw InvalidParameter::create('Query needs parameter named: email');
        }
        $query     = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $records = $statement->fetchAll(FetchMode::CUSTOM_OBJECT, UserFetchObject::class);
            if (count($records) === 0) {
                throw UserNotFound::create(sprintf('User not found by email: %s', $parameters['email']));
            }
            $item = $records[0];
            return User::create($item->id, $item->email, $item->firstName, $item->lastName, $item->createdAt);
        } catch (UserNotFound $exception) {
            throw $exception;
        }
        catch (Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}