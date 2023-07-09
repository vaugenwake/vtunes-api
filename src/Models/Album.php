<?php

namespace Vaugenwakeling\Api\Models;

class Album implements \JsonSerializable
{
    public function __construct(
        private string $partitionKey,
        private string $sortKey,
        private string $id,
        private string $name,
        private string $artist,
        private int $tracks,
        private string $coverImage
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
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     */
    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
    }

    /**
     * @return int
     */
    public function getTracks(): int
    {
        return $this->tracks;
    }

    /**
     * @param int $tracks
     */
    public function setTracks(int $tracks): void
    {
        $this->tracks = $tracks;
    }

    /**
     * @return string
     */
    public function getCoverImage(): string
    {
        return $this->coverImage;
    }

    /**
     * @param string $coverImage
     */
    public function setCoverImage(string $coverImage): void
    {
        $this->coverImage = $coverImage;
    }

    public static function fromItem(array $item): self
    {
        return new self(
            partitionKey: $item['PK'],
            sortKey: $item['SK'],
            id: $item['id'],
            name: $item['name'],
            artist: $item['artist']['name'],
            tracks: $item['track_count'],
            coverImage: $item['cover_img']
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'artist' => $this->getArtist(),
            'tracks' => $this->getTracks(),
            'cover_image' => $this->getCoverImage()
        ];
    }
}