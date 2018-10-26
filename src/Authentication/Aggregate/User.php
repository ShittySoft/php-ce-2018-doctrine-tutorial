<?php

namespace Authentication\Aggregate;

use Authentication\ReadModel\IsEmailRegistered;
use Authentication\Service\AlertSecurityOfFailedAuthentication;
use Authentication\Service\NotifyUserOfSuccessfulRegistration;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;

class User
{
    /** @var EmailAddress */
    private $emailAddress;

    /** @var PasswordHash */
    private $passwordHash;

    private function __construct(EmailAddress $emailAddress, PasswordHash $hash)
    {
        $this->emailAddress = $emailAddress;
        $this->passwordHash = $hash;
    }

    public static function register(
        EmailAddress $emailAddress,
        ClearTextPassword $password,
        IsEmailRegistered $emailRegistered,
        NotifyUserOfSuccessfulRegistration $notifySuccess
    ) : self {
        if ($emailRegistered->__invoke($emailAddress)) {
            throw new \RuntimeException(sprintf(
                'User %s is already registered',
                $emailAddress->toString()
            ));
        }

        $notifySuccess->__invoke($emailAddress);

        return new self($emailAddress, $password->makeHash());
    }

    public function authenticate(
        ClearTextPassword $password,
        AlertSecurityOfFailedAuthentication $alertSecurity
    ) : void {
        if (! $password->matches($this->passwordHash)) {
            $alertSecurity->__invoke($this->emailAddress);

            throw new \RuntimeException(sprintf(
                'Authentication failed for %s',
                $this->emailAddress->toString()
            ));
        }
    }
}
