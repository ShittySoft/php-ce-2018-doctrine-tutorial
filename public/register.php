<?php

namespace Application;

use Authentication\Aggregate\User;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\ReadModel\DoesEmailExistInRepository;
use Infrastructure\Authentication\Repository\JsonFileUsers;
use Infrastructure\Authentication\Service\SendSuccessfulRegistrationToStderr;

require_once __DIR__ . '/../vendor/autoload.php';

$users = new JsonFileUsers(__DIR__ . '/../data/users.json');
$email = EmailAddress::fromString($_POST['emailAddress']);

$users->store(User::register(
    $email,
    ClearTextPassword::fromString($_POST['password']),
    new DoesEmailExistInRepository($users),
    new SendSuccessfulRegistrationToStderr()
));

echo 'Registered';

