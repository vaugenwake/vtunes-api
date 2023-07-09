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
class AlbumController
{
    public function __construct(
        private readonly AlbumsRepository $albumsRepository
    )
    {
    }

    #[Path('/albums')]
    #[Method(HttpMethod::GET)]
    public function index(): ResponseBuilder
    {
        $albums = $this->albumsRepository->getAlbums();

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData([
                'count' => $albums->count(),
                'data' => $albums
            ]);
    }

    #[Path('/albums/{id}')]
    #[Method(HttpMethod::GET)]
    public function show(
        #[PathParameter('id')] string $id
    ): ResponseBuilder
    {
        $album = $this->albumsRepository->getAlbum($id);

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData($album);
    }
}