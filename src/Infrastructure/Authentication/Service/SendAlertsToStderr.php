<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Service;

use Authentication\Service\AlertSecurityOfFailedAuthentication;
use Authentication\Value\EmailAddress;

final class SendAlertsToStderr implements AlertSecurityOfFailedAuthentication
{
    public function __invoke(EmailAddress $emailAddress) : void
    {
        error_log(sprintf(
            'Authentication failed for %s',
            $emailAddress->toString()
        ));
    }
}
