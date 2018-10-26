<?php

namespace Application;

use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\Repository\JsonFileUsers;
use Infrastructure\Authentication\Service\SendAlertsToStderr;

require_once __DIR__ . '/../vendor/autoload.php';

$existingUsers = new JsonFileUsers(__DIR__ . '/../data/users.json');

$email    = EmailAddress::fromString($_POST['emailAddress']);
$password = ClearTextPassword::fromString($_POST['password']);

if (! $existingUsers->isRegistered($email)) {
    echo 'Nope';

    return;
}

$existingUsers
    ->get($email)
    ->authenticate($password, new SendAlertsToStderr());

echo 'OK';
