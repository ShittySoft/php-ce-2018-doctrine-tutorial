<?php

namespace Application;

use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\Repository\JsonFileUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$existingUsers = new JsonFileUsers(__DIR__ . '/../data/users.json');

$email    = EmailAddress::fromString($_POST['emailAddress']);
$password = ClearTextPassword::fromString($_POST['password']);

if (! $existingUsers->isRegistered($email)) {
    echo 'Nope';

    return;
}

if (! $existingUsers->get($email)->authenticate($password)) {
    echo 'Nope';

    return;
}

echo 'OK';
