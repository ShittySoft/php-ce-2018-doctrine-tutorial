<?php

namespace Authentication\Entity;

use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;

class User
{
    /** @var EmailAddress */
    public $emailAddress;

    /** @var PasswordHash */
    public $passwordHash;

    public function __construct(EmailAddress $emailAddress, PasswordHash $hash)
    {
        $this->emailAddress = $emailAddress;
        $this->passwordHash = $hash;
    }

    public function authenticate(ClearTextPassword $password) : bool
    {
        return $password->verify($this->passwordHash);
    }
}
