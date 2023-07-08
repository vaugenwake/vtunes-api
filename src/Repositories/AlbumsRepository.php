<?php

namespace Vaugenwakeling\Api\Repositories;

use Illuminate\Support\Collection;
use Vaugenwakeling\Api\Models\ArtistAlbum;
use Vaugenwakeling\Api\Tables\MusicTable;

class AlbumsRepository extends RepositoryAbstract
{
    public function getAlbumsByArtistId(string $id): Collection
    {
        $albums = $this->dbService->getClient()
            ->query([
               'TableName' => $this->getTableName(),
               'IndexName' => 'GSI3_ArtistAlbum',
               'KeyConditionExpression' => 'GSI3_PK = :pk',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "ARTIST#{$id}")
                )
            ]);

        return collect($albums['Items'])->map(function ($item) {
            return ArtistAlbum::fromItem($this->marshaler->unmarshalItem($item));
        });
    }
}