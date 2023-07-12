<?php

namespace Vaugenwakeling\Api\Repositories;

use Aws\Exception\AwsException;
use Illuminate\Support\Collection;
use Tuupola\Ksuid;
use Vaugenwakeling\Api\Models\Playlist;
use Vaugenwakeling\Api\Models\PlaylistSong;
use Vaugenwakeling\Api\Models\Song;

class PlaylistsRepository extends RepositoryAbstract
{
    public function createNewPlaylistForUser(string $userId, string $name): Playlist
    {
        $itemId = (new Ksuid())->string();

        $playlist = $this->dbService->getClient()
            ->putItem([
                'TableName' => $this->getTableName(),
                'Item' => $this->marshaler->marshalItem([
                    'PK' => "USER#{$userId}",
                    'SK' => "PLAYLIST#{$itemId}",
                    'id' => $itemId,
                    'user_id' => $userId,
                    'name' => $name
                ])
            ]);

        return $this->getPlaylistForUserById($userId, $itemId);
    }

    public function getPlaylistForUserById(string $userId, string $playlistId): Playlist
    {
        $item = $this->dbService->getClient()
            ->getItem([
                'TableName' => $this->getTableName(),
                'Key' => [
                    'PK' => ['S' => "USER#{$userId}"],
                    "SK" => ['S' => "PLAYLIST#{$playlistId}"]
                ]
            ]);

        return Playlist::fromItem($this->marshaler->unmarshalItem($item['Item']));
    }

    public function getPlaylistsForUserById(string $userId): Collection
    {
        $playlists = $this->dbService->getClient()
            ->query([
                'TableName' => $this->getTableName(),
                'KeyConditionExpression' => 'PK = :pk and begins_with(SK, :sk)',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "USER#{$userId}"),
                    ':sk' => array('S' => "PLAYLIST")
                ),
                'ScanIndexForward' => false
            ]);

        return collect($playlists['Items'])->map(function ($item) {
            return Playlist::fromItem($this->marshaler->unmarshalItem($item));
        });
    }

    public function getPlaylistsSongsById(string $playlistId): Collection
    {
        $songs = $this->dbService->getClient()
            ->query([
                'TableName' => $this->getTableName(),
                'KeyConditionExpression' => 'PK = :pk and begins_with(SK, :sk)',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "PLAYLIST#{$playlistId}"),
                    ':sk' => array('S' => "SONG")
                ),
                'ScanIndexForward' => false
            ]);

        return collect($songs['Items'])->map(function ($item) {
            return PlaylistSong::fromItem($this->marshaler->unmarshalItem($item));
        });
    }

    public function attachSongToPlaylist(string $playlistId, Song $song): bool
    {
        try {
            $attached = $this->dbService->getClient()
                ->putItem([
                    'TableName' => $this->getTableName(),
                    'Item' => [
                        'PK' => ['S' => "PLAYLIST#{$playlistId}"],
                        'SK' => ['S' => "SONG#{$song->getId()}"],
                        'id' => ['S' => $song->getId()],
                        'name' => ['S' => $song->getName()],
                        'duration' => ['S' => $song->getDuration()]
                    ]
                ]);

            return true;
        } catch (AwsException $e) {
            return false;
        }
    }
}