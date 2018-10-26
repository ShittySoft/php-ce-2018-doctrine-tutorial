<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Service;

use Authentication\Service\NotifyUserOfSuccessfulRegistration;
use Authentication\Value\EmailAddress;

final class SendSuccessfulRegistrationToStderr implements NotifyUserOfSuccessfulRegistration
{
    public function __invoke(EmailAddress $emailAddress) : void
    {
        error_log(sprintf(
            'Registration successful for %s',
            $emailAddress->toString()
        ));
    }
}
