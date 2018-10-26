<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Authentication\Aggregate\User;
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

        $this->reflectionEmailAddress()->setValue($user, $emailAddress);
        $this->reflectionPasswordHash()->setValue($user, PasswordHash::fromString($passwordHash));

        return $user;
    }

    public function store(User $user) : void
    {
        $users = $this->existingUsers();

        $users[
            $this->reflectionEmailAddress()->getValue($user)->toString()
        ] = $this->reflectionPasswordHash()->getValue($user)->toString();

        file_put_contents($this->file, json_encode($users));
    }

    /** @return array<string, string> */
    private function existingUsers() : array
    {
        return json_decode(file_get_contents($this->file), true);
    }

    private function reflectionEmailAddress() : \ReflectionProperty
    {
        $property = new \ReflectionProperty(User::class, 'emailAddress');

        $property->setAccessible(true);

        return $property;
    }

    private function reflectionPasswordHash() : \ReflectionProperty
    {
        $property = new \ReflectionProperty(User::class, 'passwordHash');

        $property->setAccessible(true);

        return $property;
    }
}
