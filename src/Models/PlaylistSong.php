<?php

namespace Vaugenwakeling\Api\Models;

class PlaylistSong implements \JsonSerializable
{
    public function __construct(
        private string $partitionKey,
        private string $sortKey,
        private string $id,
        private string $name,
        private int $duration
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public static function fromItem(array $item): self
    {
        return new self(
            partitionKey: $item['PK'],
            sortKey: $item['SK'],
            id: $item['id'],
            name: $item['name'],
            duration: $item['duration']
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'duration' => $this->getDuration()
        ];
    }
}