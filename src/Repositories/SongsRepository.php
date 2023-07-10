<?php

namespace Vaugenwakeling\Api\Repositories;

use Illuminate\Support\Collection;
use Vaugenwakeling\Api\Models\Song;

class SongsRepository extends RepositoryAbstract
{
    public function getSongsForAlbumById(string $albumId): Collection
    {
        $albums = $this->dbService->getClient()
            ->query([
                'TableName' => $this->getTableName(),
                'KeyConditionExpression' => 'PK = :pk and begins_with(SK, :sk)',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "ALBUM#{$albumId}"),
                    ':sk' => array('S' => "SONG")
                )
            ]);

        /**
        $albums = $this->dbService->getClient()
        ->query([
        'TableName' => $this->getTableName(),
        'IndexName' => 'GSI4_AlbumSongs',
        'KeyConditionExpression' => 'GSI4_PK = :pk and begins_with(GSI4_SK, :sk)',
        'ExpressionAttributeValues' =>  array (
        ':pk'  => array('S' => "ALBUM#{$albumId}"),
        ':sk' => array('S' => "SONG")
        )
        ]);
         */

        return collect($albums['Items'])->map(function ($item) {
            return Song::fromItem($this->marshaler->unmarshalItem($item));
        });
    }
}