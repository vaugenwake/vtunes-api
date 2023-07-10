<?php

namespace Vaugenwakeling\Api\Repositories;

use Illuminate\Support\Collection;
use Vaugenwakeling\Api\Models\Album;
use Vaugenwakeling\Api\Models\ArtistAlbum;

class AlbumsRepository extends RepositoryAbstract
{
    public function getAlbumsByArtistId(string $id): Collection
    {
        $albums = $this->dbService->getClient()
            ->query([
               'TableName' => $this->getTableName(),
               'IndexName' => 'GSI3_ArtistAlbums',
               'KeyConditionExpression' => 'GSI3_PK = :pk',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "ARTIST#{$id}")
                )
            ]);

        return collect($albums['Items'])->map(function ($item) {
            return ArtistAlbum::fromItem($this->marshaler->unmarshalItem($item));
        });
    }

    public function getAlbums(): Collection
    {
        $albums = $this->dbService->getClient()
            ->query([
                'TableName' => $this->getTableName(),
                'IndexName' => 'GSI2_Albums',
                'KeyConditionExpression' => 'GSI2_PK = :pk and begins_with(GSI2_SK, :sk)',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "ALBUM"),
                    ':sk' => array('S' => "ALBUM")
                )
            ]);

        return collect($albums['Items'])->map(function ($item) {
            return Album::fromItem($this->marshaler->unmarshalItem($item));
        });
    }

    public function getAlbum(string $id): Album
    {
        $album = $this->dbService->getClient()
            ->query([
                'TableName' => $this->getTableName(),
                'IndexName' => 'GSI2_Albums',
                'KeyConditionExpression' => 'GSI2_PK = :pk and GSI2_SK = :sk',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "ALBUM"),
                    ':sk' => array('S' => "ALBUM#{$id}")
                )
            ]);

        return Album::fromItem($this->marshaler->unmarshalItem($album['Items'][0]));
    }
}