<?php

declare(strict_types=1);

namespace Authentication\Service;

use Authentication\Value\EmailAddress;

interface AlertSecurityOfFailedAuthentication
{
    public function __invoke(EmailAddress $emailAddress) : void;
}
