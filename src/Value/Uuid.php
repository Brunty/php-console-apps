<?php

namespace App\Value;

class Uuid
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct(?string $uuidString = null)
    {
        $this->uuid = $uuidString ?? \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
