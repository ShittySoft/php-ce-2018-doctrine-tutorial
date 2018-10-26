<?php

declare(strict_types=1);

namespace Authentication\Service;

use Authentication\Value\EmailAddress;

interface NotifyUserOfSuccessfulRegistration
{
    public function __invoke(EmailAddress $emailAddress) : void;
}
