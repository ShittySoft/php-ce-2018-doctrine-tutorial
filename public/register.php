<?php

namespace Application;

use Authentication\Entity\User;
use Infrastructure\Authentication\Repository\JsonFileUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$existingUsers = new JsonFileUsers(__DIR__ . '/../data/users.json');
$email         = $_POST['emailAddress'];
$password      = $_POST['password'];

if ($existingUsers->isRegistered($email)) {
    echo 'Already registered';

    return;
}

$existingUsers->store(new User($email, $password));

// Maybe notification system? Later...
error_log(sprintf('User %s registered', $email));

echo 'Registered';

