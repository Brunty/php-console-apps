<?php declare(strict_types=1);

namespace App\Entity;

use App\Value\Uuid;

class Task
{
    /**
     * @var Uuid
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeInterface
     */
    private $addedOn;

    /**
     * @var bool
     */
    private $isComplete = false;

    public function __construct(Uuid $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->addedOn = new \DateTimeImmutable;
    }

    public static function fromName(string $name, \DateTimeInterface $addedOn = null): self
    {
        return new self(new Uuid, $name, $addedOn);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddedOn(): \DateTimeInterface
    {
        return $this->addedOn;
    }

    public function complete(): self
    {
        $this->isComplete = true;

        return $this;
    }

    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    public function changeName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
