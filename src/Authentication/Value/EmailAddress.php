<?php

declare(strict_types=1);

namespace Authentication\Value;

final class EmailAddress
{
    /** @var string */
    private $emailAddress;

    private function __construct()
    {
    }

    public static function fromString(string $string) : self
    {
        if (! \filter_var($string, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid email "%s" provided',
                $string
            ));
        }

        $instance = new self();

        $instance->emailAddress = $string;

        return $instance;
    }

    public function toString() : string
    {
        return $this->emailAddress;
    }
}
