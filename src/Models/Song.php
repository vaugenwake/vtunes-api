<?php

namespace Vaugenwakeling\Api\Models;

class Song implements \JsonSerializable
{
    public function __construct(
        private string $partitionKey,
        private string $sortKey,
        private string $id,
        private string $name,
        private string $type,
        private int $trackCount,
        private int $duration,
        private bool $explicit
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getTrackCount(): int
    {
        return $this->trackCount;
    }

    /**
     * @param int $trackCount
     */
    public function setTrackCount(int $trackCount): void
    {
        $this->trackCount = $trackCount;
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

    /**
     * @return bool
     */
    public function isExplicit(): bool
    {
        return $this->explicit;
    }

    /**
     * @param bool $explicit
     */
    public function setExplicit(bool $explicit): void
    {
        $this->explicit = $explicit;
    }

    public static function fromItem(array $item): self
    {
        return new self(
            partitionKey: $item['PK'],
            sortKey: $item['SK'],
            id: $item['id'],
            name: $item['name'],
            type: $item['type'],
            trackCount: $item['track_num'],
            duration: $item['duration'],
            explicit: $item['explicit']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'track_count' => $this->getTrackCount(),
            'duration' => $this->getDuration(),
            'explicit' => $this->isExplicit()
        ];
    }
}