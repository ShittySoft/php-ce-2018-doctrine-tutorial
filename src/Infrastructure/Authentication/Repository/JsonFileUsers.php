<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;

final class JsonFileUsers implements Users
{
    /** @var string */
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function isRegistered(EmailAddress $emailAddress) : bool
    {
        return isset($this->existingUsers()[$emailAddress->toString()]);
    }

    public function get(EmailAddress $emailAddress) : User
    {
        $passwordHash = $this->existingUsers()[$emailAddress->toString()] ?? null;

        if (null === $passwordHash) {
            throw new \Exception(sprintf('User %s does not exist', $emailAddress->toString()));
        }

        $user = (new \ReflectionClass(User::class))
            ->newInstanceWithoutConstructor();

        $user->emailAddress = $emailAddress;
        $user->passwordHash = PasswordHash::fromString($passwordHash);

        return $user;
    }

    public function store(User $user) : void
    {
        $users = $this->existingUsers();

        $users[$user->emailAddress->toString()] = $user->passwordHash->toString();

        file_put_contents($this->file, json_encode($users));
    }

    /** @return array<string, string> */
    private function existingUsers() : array
    {
        return json_decode(file_get_contents($this->file), true);
    }
}
