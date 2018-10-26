<?php

namespace Application;

use Infrastructure\Authentication\Repository\JsonFileUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$existingUsers = new JsonFileUsers(__DIR__ . '/../data/users.json');

$email = $_POST['emailAddress'];
$password = $_POST['password'];

if (! $existingUsers->isRegistered($email)) {
    echo 'Nope';

    return;
}

$user = $existingUsers->get($email);

if (! password_verify($password, $user->passwordHash)) {
    echo 'Nope';

    return;
}

echo 'OK';
