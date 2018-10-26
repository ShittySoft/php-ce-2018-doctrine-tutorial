<?php

namespace Authentication\Entity;

class User
{
    /** @var string */
    public $emailAddress;

    /** @var string */
    public $passwordHash;

    public function __construct(string $emailAddress, string $password)
    {
        $this->emailAddress = $emailAddress;
        $this->passwordHash = password_hash($password, \PASSWORD_DEFAULT);
    }
}
