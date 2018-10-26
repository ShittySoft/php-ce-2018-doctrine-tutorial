<?php

declare(strict_types=1);

namespace Authentication\ReadModel;

use Authentication\Value\EmailAddress;

interface IsEmailRegistered
{
    public function __invoke(EmailAddress $emailAddress) : bool;
}
