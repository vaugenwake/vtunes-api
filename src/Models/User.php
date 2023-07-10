<?php

namespace Vaugenwakeling\Api\Models;

use Illuminate\Support\Facades\Hash;

class User implements \JsonSerializable
{
    public function __construct(
        private string $partitionKey,
        private string $sortKey,
        private string $id,
        private ?string $name,
        private string $email,
        #[\SensitiveParameter] private string $password,
        private bool $active
    )
    {
    }

    /**
     * @return string
     */
    public function getPartitionKey(): string
    {
        return $this->partitionKey;
    }

    /**
     * @param string $partitionKey
     */
    public function setPartitionKey(string $partitionKey): void
    {
        $this->partitionKey = $partitionKey;
    }

    /**
     * @return string
     */
    public function getSortKey(): string
    {
        return $this->sortKey;
    }

    /**
     * @param string $sortKey
     */
    public function setSortKey(string $sortKey): void
    {
        $this->sortKey = $sortKey;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param ?string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    private function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function authenticate(string $password): bool
    {
        return password_verify($password, $this->getPassword());
    }

    public static function fromItem(array $item): self
    {
        return new self(
            partitionKey: $item['PK'],
            sortKey: $item['SK'],
            id: $item['id'],
            name: $item['name'],
            email: $item['email'],
            password: $item['pass'],
            active: $item['active']
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'active' => $this->isActive()
        ];
    }
}