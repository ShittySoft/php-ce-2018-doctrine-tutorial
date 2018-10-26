<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\ReadModel;

use Authentication\ReadModel\IsEmailRegistered;
use Authentication\Repository\Users;
use Authentication\Value\EmailAddress;

final class DoesEmailExistInRepository implements IsEmailRegistered
{
    /** @var Users */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function __invoke(EmailAddress $emailAddress) : bool
    {
        return $this->users->isRegistered($emailAddress);
    }
}
