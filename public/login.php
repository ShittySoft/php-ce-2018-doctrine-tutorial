<?php

$existingUsers = json_decode(
    file_get_contents(__DIR__ . '/../data/users.json'),
    true
);

$email = $_POST['emailAddress'];
$password = $_POST['password'];

if (! isset($existingUsers[$email])) {
    echo 'Nope';

    return;
}

if (! password_verify($password, $existingUsers[$email])) {
    echo 'Nope';

    return;
}

echo 'OK';
