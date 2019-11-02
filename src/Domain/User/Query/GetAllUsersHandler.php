<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Query;

use Reformo\Domain\User\Interfaces\UserQuery;
use Reformo\Domain\User\Model\UsersCollection;

class GetAllUsersHandler
{
    private $repository;

    public function __construct(UserQuery $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetAllUsers $command) : UsersCollection
    {
        return $this->repository->getAllUsersPaginated($command->offset(), $command->limit());
    }
}
