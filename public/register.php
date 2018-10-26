<?php

$existingUsers = json_decode(
    file_get_contents(__DIR__ . '/../data/users.json'),
    true
);

$email = $_POST['emailAddress'];
$password = $_POST['password'];

if ($existingUsers[$email]) {
    echo 'Already registered';

    return;
}

$existingUsers[$email] = password_hash($password, \PASSWORD_DEFAULT);

file_put_contents(
    __DIR__ . '/../data/users.json',
    json_encode($existingUsers)
);

error_log(sprintf('User %s registered', $email));

echo 'Registered';

