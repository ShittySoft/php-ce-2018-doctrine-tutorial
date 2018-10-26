<?php

declare(strict_types=1);

namespace Authentication\Value;

final class PasswordHash
{
    /** @var string */
    private $hash;

    private function __construct()
    {
    }

    public static function fromString(string $string) : self
    {
        if (0 !== strpos($string, '$')) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid password hash "%s" provided',
                $string
            ));
        }

        $instance = new self();

        $instance->hash = $string;

        return $instance;
    }

    public function toString() : string
    {
        return $this->hash;
    }
}
