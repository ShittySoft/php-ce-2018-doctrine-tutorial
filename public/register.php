<?php

namespace Application;

use Authentication\Entity\User;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\Repository\JsonFileUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$existingUsers = new JsonFileUsers(__DIR__ . '/../data/users.json');
$email         = EmailAddress::fromString($_POST['emailAddress']);
$password      = ClearTextPassword::fromString($_POST['password']);

if ($existingUsers->isRegistered($email)) {
    echo 'Already registered';

    return;
}

$existingUsers->store(new User($email, $password->makeHash()));

// Maybe notification system? Later...
error_log(sprintf('User %s registered', $email->toString()));

echo 'Registered';

