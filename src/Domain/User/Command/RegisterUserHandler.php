<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

class RegisterUserHandler
{
    public function __construct()
    {
    }

    public function __invoke(RegisterUser $command) : string
    {
        return "User {$command->emailAddress} is registered!";
    }
}
