<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\AlbumsRepository;
use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Parameter\PathParameter;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class ArtistAlbumsController
{
    public function __construct(
        private readonly AlbumsRepository $albumsRepository
    )
    {
    }

    #[Path('/artists/{id}/albums')]
    #[Method(HttpMethod::GET)]
    public function index(
        #[PathParameter('id')] string $id
    ): ResponseBuilder
    {
        $albums = $this->albumsRepository->getAlbumsByArtistId($id);

        return (new ResponseBuilder())
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setData([
                'count' => $albums->count(),
                'data' => $albums->toArray()
            ]);
    }
}