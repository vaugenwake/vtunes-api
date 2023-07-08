<?php

namespace Vaugenwakeling\Api\Repositories;

use Vaugenwakeling\Api\Models\Artist;

class ArtistsRepository extends RepositoryAbstract
{
    public function getArtistById(string $id): Artist
    {
        $artist = $this->dbService->getClient()
            ->getItem([
                'TableName' => $this->getTableName(),
                'Key' => [
                    'PK' => ['S' => "ARTIST#{$id}"],
                    'SK' => ['S' => "ARTIST"]
                ]
            ]);

        return Artist::fromItem(
            $this->marshaler->unmarshalItem($artist['Item'])
        );
    }
}